<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;
use App\Extractor\ExtractorInterface;
use App\Hydrator\HydratorInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CustomerService
 * @package App\Service
 */
class CustomerService implements CustomerServiceInterface
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
    private ExtractorInterface $customerExtractor;

    /**
     * CustomerService constructor.
     * @param EntityManagerInterface $entityManager
     * @param HydratorInterface $hydrator
     * @param ExtractorInterface $customerExtractor
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        HydratorInterface $hydrator,
        ExtractorInterface $customerExtractor
    ) {
        $this->entityManager = $entityManager;
        $this->hydrator = $hydrator;
        $this->customerExtractor = $customerExtractor;
    }

    /**
     * @param array $data
     * @return Customer
     */
    public function create(array $data): Customer
    {
        $customer = new Customer();
        $this->getHydrator()->hydrate($data, $customer);
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($customer);

        return $customer;
    }

    /**
     * @param array $data
     * @return Customer
     */
    public function update(array $data): Customer
    {
        $customer = $this->getEntityManager()->find(Customer::class, $data['id']);
        $this->getHydrator()->hydrate($data, $customer);
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($customer);

        return $customer;
    }

    /**
     * @param int $customerId
     * @return array
     */
    public function get(int $customerId): array
    {
        $customer = $this->getEntityManager()->find(Customer::class, $customerId);

        return $this->getCustomerExtractor()->extract($customer);
    }

    /**
     * @param string $phone
     * @return int|null
     */
    public function find(string $phone): ?int
    {
        $customer = $this->getEntityManager()->getRepository(Customer::class)->findOneBy([
            'phone' => $phone,
        ]);

        return $customer === null ? null : $customer->getId();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getCustomers(int $limit, int $offset): array
    {
        $customerRepository = $this->getEntityManager()->getRepository(Customer::class);

        $data = $customerRepository->getCustomers($limit, $offset);
        $count = $customerRepository->getCount();

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
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * @return ExtractorInterface
     */
    public function getCustomerExtractor(): ExtractorInterface
    {
        return $this->customerExtractor;
    }
}
