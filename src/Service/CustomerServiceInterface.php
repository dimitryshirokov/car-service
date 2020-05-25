<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;

/**
 * Interface CustomerServiceInterface
 * @package App\Service
 */
interface CustomerServiceInterface
{
    /**
     * @param array $data
     * @return Customer
     */
    public function create(array $data): Customer;

    /**
     * @param array $data
     * @return Customer
     */
    public function update(array $data): Customer;

    /**
     * @param int $customerId
     * @return array
     */
    public function get(int $customerId): array;

    /**
     * @param string $phone
     * @return int|null
     */
    public function find(string $phone): ?int;

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getCustomers(int $limit, int $offset): array;
}
