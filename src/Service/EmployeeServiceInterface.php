<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Employee;

/**
 * Interface EmployeeServiceInterface
 * @package App\Service
 */
interface EmployeeServiceInterface
{
    /**
     * @param array $data
     * @return Employee
     */
    public function create(array $data): Employee;

    /**
     * @param array $data
     * @param int|null $employeeId
     * @return Employee
     */
    public function update(array $data, ?int $employeeId): Employee;

    /**
     * @param int $employeeId
     * @return Employee|null
     */
    public function get(int $employeeId): ?Employee;

    /**
     * @param int $employeeId
     * @return Employee
     */
    public function delete(int $employeeId): Employee;

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit, int $offset): array;

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id): array;
}
