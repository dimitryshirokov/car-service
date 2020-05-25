<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class EmployeeRepository
 * @package App\Repository
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Employee[] findAll()
 */
class EmployeeRepository extends ServiceEntityRepository
{
    /**
     * EmployeeRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param bool $active
     * @return array
     */
    public function getAll(?int $limit, ?int $offset, bool $active = true): array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        $query = $qb->select([
            'e.id',
            "CONCAT_WS(' ', e.surname, e.name, e.patronymic) as fio",
            'e.start_date as startDate',
            'p.title as position',
            'p.type as positionType',
        ])->from('employee', 'e')
            ->innerJoin('e', 'position', 'p', 'p.id = e.position_id')
            ->where($expr->eq('e.active', (int) $active));

        if ($limit !== null && $offset !== null) {
            $query->setMaxResults($limit)
                ->setFirstResult($offset);
        }

        return $query->execute()->fetchAll();
    }

    /**
     * @return int
     */
    public function getAllCount(): int
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        return (int) $qb->select('COUNT(e.id)')
            ->from('employee', 'e')
            ->where($expr->eq('e.active', 1))
            ->execute()
            ->fetchColumn();
    }
}
