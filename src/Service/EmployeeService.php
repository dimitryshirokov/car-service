<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Employee;
use App\Entity\Position;
use App\Extractor\ExtractorInterface;
use App\Hydrator\HydratorInterface;
use App\Repository\EmployeeRepository;
use App\Repository\PositionRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EmployeeService
 * @package App\Service
 */
class EmployeeService implements EmployeeServiceInterface
{
    /**
     * @var HydratorInterface
     */
    private HydratorInterface $hydrator;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var ExtractorInterface
     */
    private ExtractorInterface $extractor;

    /**
     * EmployeeService constructor.
     * @param HydratorInterface $hydrator
     * @param EntityManagerInterface $entityManager
     * @param ExtractorInterface $extractor
     */
    public function __construct(
        HydratorInterface $hydrator,
        EntityManagerInterface $entityManager,
        ExtractorInterface $extractor
    ) {
        $this->hydrator = $hydrator;
        $this->entityManager = $entityManager;
        $this->extractor = $extractor;
    }

    /**
     * @param array $data
     * @return Employee
     */
    public function create(array $data): Employee
    {
        return $this->update($data, null);
    }

    /**
     * @param array $data
     * @param int|null $employeeId
     * @return Employee
     */
    public function update(array $data, ?int $employeeId): Employee
    {
        $employee = null;
        if ($employeeId !== null) {
            $employee = $this->getEmployeeRepository()->find($employeeId);
        }
        if ($employee === null) {
            $employee = new Employee();
        }
        $this->getHydrator()->hydrate($data, $employee);
        $position = $this->getPositionRepository()->findOneBy([
            'type' => $data['positionType'],
        ]);
        if ($position === null) {
            throw new \RuntimeException();
        }
        $employee->setPosition($position);

        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();

        $this->getEntityManager()->refresh($employee);

        return $employee;
    }

    /**
     * @param int $employeeId
     * @return Employee|null
     */
    public function get(int $employeeId): ?Employee
    {
        $employee = $this->getEmployeeRepository()->find($employeeId);
        if ($employee === null) {
            throw new \RuntimeException();
        }

        return $employee;
    }

    /**
     * @param int $employeeId
     * @return Employee
     */
    public function delete(int $employeeId): Employee
    {
        $employee = $this->get($employeeId);
        $employee->setActive(false);
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit, int $offset): array
    {
        $results = $this->getEmployeeRepository()->getAll($limit, $offset);

        $count = $this->getEmployeeRepository()->getAllCount();

        return [
            'results' => $results,
            'count' => $count,
            'countFiltered' => $count,
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $employee = $this->get($id);
        $employee = $this->getExtractor()->extract($employee);

        return $employee;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return EmployeeRepository
     */
    public function getEmployeeRepository(): EmployeeRepository
    {
        return $this->getEntityManager()->getRepository(Employee::class);
    }

    /**
     * @return PositionRepository
     */
    public function getPositionRepository(): PositionRepository
    {
        return $this->getEntityManager()->getRepository(Position::class);
    }

    /**
     * @return ExtractorInterface
     */
    public function getExtractor(): ExtractorInterface
    {
        return $this->extractor;
    }
}
