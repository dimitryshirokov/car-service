<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use App\Entity\Customer;
use App\Extractor\ExtractorInterface;
use App\Hydrator\HydratorInterface;
use App\Service\Exception\ValidationException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CarService
 * @package App\Service
 */
class CarService implements CarServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    /**
     * @var ExtractorInterface
     */
    private ExtractorInterface $extractor;

    /**
     * CarService constructor.
     * @param EntityManagerInterface $entityManager
     * @param HydratorInterface $hydrator
     * @param ExtractorInterface $extractor
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        HydratorInterface $hydrator,
        ExtractorInterface $extractor
    ) {
        $this->entityManager = $entityManager;
        $this->hydrator = $hydrator;
        $this->extractor = $extractor;
    }

    /**
     * @param array $data
     * @return Car
     */
    public function create(array $data): Car
    {
        $car = new Car();

        $carCheck = $this->getEntityManager()->getRepository(Car::class)->findOneBy([
            'vin' => $data['vin'],
        ]);

        if ($carCheck !== null) {
            $car = $carCheck;
        }

        $customer = $this->getEntityManager()->getRepository(Customer::class)->findOneBy([
            'phone' => $data['phone'],
        ]);

        if ($customer === null) {
            throw new ValidationException('Не найден клиент с телефоном ' . $data['phone']);
        }

        $this->getHydrator()->hydrate($data, $car);

        $customerCars = $customer->getCars();
        $customerCars->add($car);
        $customer->setCars($customerCars);

        $carCustomers = $car->getCustomers();
        $carCustomers->add($customer);
        $car->setCustomers($carCustomers);

        $this->getEntityManager()->persist($car);
        $this->getEntityManager()->flush();

        $this->getEntityManager()->refresh($car);

        return $car;
    }

    /**
     * @param int $carId
     * @return array
     */
    public function get(int $carId): array
    {
        $car = $this->getEntityManager()->find(Car::class, $carId);

        return $this->getExtractor()->extract($car);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit, int $offset): array
    {
        $carRepository = $this->getEntityManager()->getRepository(Car::class);

        $data = $carRepository->getList($limit, $offset);
        $count = $carRepository->getCount();

        return [
            'data' => $data,
            'count' => $count,
            'countFiltered' => $count,
        ];
    }

    /**
     * @param string $vin
     * @return int|null
     */
    public function findCar(string $vin): ?int
    {
        $car = $this->getEntityManager()->getRepository(Car::class)->findOneBy([
            'vin' => $vin
        ]);

        return $car === null ? null : $car->getId();
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * @return ExtractorInterface
     */
    public function getExtractor(): ExtractorInterface
    {
        return $this->extractor;
    }
}
