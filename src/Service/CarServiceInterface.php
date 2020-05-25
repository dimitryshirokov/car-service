<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;

/**
 * Interface CarServiceInterface
 * @package App\Service
 */
interface CarServiceInterface
{
    /**
     * @param array $data
     * @return Car
     */
    public function create(array $data): Car;

    /**
     * @param int $carId
     * @return array
     */
    public function get(int $carId): array;

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit, int $offset): array;

    /**
     * @param string $vin
     * @return int|null
     */
    public function findCar(string $vin): ?int;
}
