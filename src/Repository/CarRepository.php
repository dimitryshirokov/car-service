<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CarRepository
 * @package App\Repository
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Car[] findAll()
 */
class CarRepository extends ServiceEntityRepository
{
    /**
     * CarRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getList(?int $limit, ?int $offset): array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        $lastOrderDateQb = clone $qb;
        $lastOrderIdQb = clone $qb;

        $lastOrderDateQuery = $lastOrderDateQb
            ->select('o.created')
            ->from('orders', 'o')
            ->where($expr->eq('o.car_id', 'c.id'))
            ->orderBy('o.created', 'DESC')
            ->setMaxResults(1);

        $lastOrderIdQuery = $lastOrderIdQb
            ->select('o.id')
            ->from('orders', 'o')
            ->where($expr->eq('o.car_id', 'c.id'))
            ->orderBy('o.created', 'DESC')
            ->setMaxResults(1);

        $query = $qb->select([
            'c.id',
            'c.manufacturer',
            'c.model',
            'c.engine',
            'c.year',
            'c.vin',
            '(' . $lastOrderDateQuery->getSQL() . ') as lastOrderDate',
            '(' . $lastOrderIdQuery->getSQL() . ') as lastOrderId',
        ])->from('car', 'c');

        if ($limit !== null && $offset !== null) {
            $query->setMaxResults($limit)
                ->setFirstResult($offset);
        }

        $query->orderBy('c.id', 'DESC');

        return $query->execute()->fetchAll();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();

        return (int) $qb->select('COUNT(c.id)')
            ->from('car', 'c')
            ->execute()
            ->fetchColumn();
    }
}
