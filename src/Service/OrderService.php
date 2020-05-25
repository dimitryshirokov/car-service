<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\DoneWork;
use App\Entity\Employee;
use App\Entity\Order;
use App\Entity\Part;
use App\Entity\Position;
use App\Entity\Work;
use App\Extractor\ExtractorInterface;
use App\Service\Exception\ValidationException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class OrderService
 * @package App\Service
 */
class OrderService implements OrderServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ExtractorInterface
     */
    private ExtractorInterface $orderExtractor;

    /**
     * OrderService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ExtractorInterface $orderExtractor
     */
    public function __construct(EntityManagerInterface $entityManager, ExtractorInterface $orderExtractor)
    {
        $this->entityManager = $entityManager;
        $this->orderExtractor = $orderExtractor;
    }

    /**
     * @return array
     */
    public function getWorksAndEmployers(): array
    {
        return [
            'works' => $this->getWorksToCreateOrder(),
            'employers' => $this->getEmployersToCreateOrder(),
        ];
    }

    /**
     * @return array
     */
    private function getEmployersToCreateOrder(): array
    {
        $employeeRepository = $this->getEntityManager()->getRepository(Employee::class);

        $employers = $employeeRepository->getAll(null, null);
        $employersResult = [];
        foreach ($employers as $employer) {
            $employersResult[$employer['positionType']][] = [
                'id' => $employer['id'],
                'fio' => $employer['fio'],
            ];
        }

        return $employersResult;
    }

    /**
     * @return array
     */
    private function getWorksToCreateOrder(): array
    {
        $workRepository = $this->getEntityManager()->getRepository(Work::class);
        $works = $workRepository->getWorks(null, null);
        $worksResult = [];
        foreach ($works as $work) {
            $positionTypes = [];
            $positions = explode(',', $work['positionTypes']);
            foreach ($positions as $position) {
                $positionTypes[$position] = Position::translateType($position);
            }
            $worksResult[] = [
                'id' => $work['id'],
                'title' => $work['title'],
                'price' => $work['price'],
                'positionTypes' => $positionTypes,
            ];
        }

        return $worksResult;
    }

    /**
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order
    {
        $customerRepository = $this->getEntityManager()->getRepository(Customer::class);
        $carRepository = $this->getEntityManager()->getRepository(Car::class);
        $order = new Order();
        $this->createDoneWorks($data['works'], $order);
        $this->createParts($data['parts'], $order);
        $customer = $customerRepository->findOneBy([
            'phone' => $data['phone'],
        ]);
        if ($customer === null) {
            throw new ValidationException('Не найден пользователь с телефоном ' . $data['phone']);
        }
        $car = $carRepository->findOneBy([
            'vin' => $data['vin'],
        ]);
        if ($car === null) {
            throw new ValidationException('Не найден автомобиль с VIN ' . $data['vin']);
        }
        $carOrders = $car->getOrders();
        $carOrders->add($order);
        $car->setOrders($carOrders);
        $price = '0';
        foreach ($order->getDoneWorks() as $doneWork) {
            $price = bcadd($price, $doneWork->getPrice());
        }
        foreach ($order->getParts() as $part) {
            $price = bcadd($price, $part->getCost());
        }

        $totalPrice = bcmul(
            $price,
            bcsub(
                '1',
                $customer->getDiscount()
            )
        );

        $order->setCustomer($customer)
            ->setPrice($price)
            ->setCar($car)
            ->setTotalPrice($totalPrice);

        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();

        $this->getEntityManager()->refresh($order);

        return $order;
    }

    /**
     * @param array $parts
     * @param Order $order
     */
    private function createParts(array $parts, Order $order): void
    {
        $orderParts = $order->getParts();
        foreach ($parts as $partArray) {
            $part = new Part();
            $part->setOrder($order)
                ->setTitle($partArray['title'])
                ->setPartNumber($partArray['number'])
                ->setCost($partArray['price']);
            $orderParts->add($part);
        }
        $order->setParts($orderParts);
    }

    /**
     * @param array $works
     * @param Order $order
     */
    private function createDoneWorks(array $works, Order $order): void
    {
        if (count($works) === 0) {
            throw new ValidationException('Отсутствуют работы по заказу!');
        }
        $orderDoneWorks = $order->getDoneWorks();
        $workRepository = $this->getEntityManager()->getRepository(Work::class);
        foreach ($works as $workArray) {
            $doneWork = new DoneWork();
            $work = $workRepository->find($workArray['id']);
            $doneWork->setCountOfWork($workArray['hours']);
            $price = $work->getPrice();
            $price = bcmul($price, (string) $workArray['hours']);
            $doneWork->setPrice($price)
                ->setWork($work)
                ->setOrder($order);
            $doneWorks = $work->getDoneWorks();
            $doneWorks->add($doneWork);
            $work->setDoneWorks($doneWorks);
            $this->addEmployers($workArray['employers'], $doneWork);
            $orderDoneWorks->add($doneWork);
        }
        $order->setDoneWorks($orderDoneWorks);
    }

    /**
     * @param array $employers
     * @param DoneWork $doneWork
     */
    private function addEmployers(array $employers, DoneWork $doneWork): void
    {
        $employeeRepository = $this->getEntityManager()->getRepository(Employee::class);
        foreach ($employers as $employerId) {
            $employer = $employeeRepository->find($employerId);
            $doneWorkEmployers = $doneWork->getEmployers();
            $employerDoneWorks = $employer->getDoneWorks();
            $doneWorkEmployers->add($employer);
            $doneWork->setEmployers($doneWorkEmployers);
            $employerDoneWorks->add($doneWork);
            $employer->setDoneWorks($employerDoneWorks);
        }
    }

    /**
     * @param int $orderId
     * @return array
     */
    public function getOrder(int $orderId): array
    {
        $order = $this->getEntityManager()->find(Order::class, $orderId);

        return $this->getOrderExtractor()->extract($order);
    }

    /**
     * @param int $orderId
     * @param string $status
     * @return Order
     */
    public function changeOrderStatus(int $orderId, string $status): Order
    {
        $order = $this->getEntityManager()->find(Order::class, $orderId);
        $order->setStatus($status);
        if ($status === Order::STATUS_DONE || $status === Order::STATUS_CANCELLED) {
            foreach ($order->getDoneWorks() as $doneWork) {
                $doneWork->setActive(false);
            }
        }

        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();

        return $order;
    }

    /**
     * @param int $id
     * @return int|null
     */
    public function findOrder(int $id): ?int
    {
        $order = $this->getEntityManager()->find(Order::class, $id);

        return $order === null ? $order : $order->getId();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $status
     * @return array
     */
    public function getOrders(int $limit, int $offset, string $status): array
    {
        $orderRepository = $this->getEntityManager()->getRepository(Order::class);

        $data = $orderRepository->getOrders($limit, $offset, $status);
        $count = $orderRepository->getCount($status);

        return [
            'data' => $data,
            'count' => $count,
            'countFiltered' => $count,
        ];
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return ExtractorInterface
     */
    public function getOrderExtractor(): ExtractorInterface
    {
        return $this->orderExtractor;
    }
}
