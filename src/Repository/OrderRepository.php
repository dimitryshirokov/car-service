<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class OrderRepository
 * @package App\Repository
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Order[] findAll()
 */
class OrderRepository extends ServiceEntityRepository
{
    /**
     * OrderRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @param string|null $status
     * @return array
     */
    public function getOrders(?int $limit, ?int $offset, ?string $status): array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        $query = $qb->select([
            'o.id',
            'o.created',
            'o.price',
            'o.total_price as totalPrice',
            'o.status',
            "CONCAT_WS(' ', c.surname, c.name, c.patronymic) as customer",
            'c.id as customerId',
            'c1.vin'
        ])->from('orders', 'o')
            ->innerJoin('o', 'customer', 'c', 'o.customer_id = c.id')
            ->innerJoin('o', 'car', 'c1', 'o.car_id = c1.id');

        if ($status !== null) {
            $query->where($expr->eq('o.status', $expr->literal($status)));
        }

        if ($limit !== null && $offset !== null) {
            $query->setMaxResults($limit)
                ->setFirstResult($offset);
        }

        $query->orderBy('o.id', 'DESC');

        return $query->execute()->fetchAll();
    }

    /**
     * @param string|null $status
     * @return int
     */
    public function getCount(?string $status): int
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        $query = $qb->select('COUNT(o.id)')
            ->from('orders', 'o');

        if ($status !== null) {
            $query->where($expr->eq('o.status', $expr->literal($status)));
        }

        return (int) $query->execute()->fetchColumn();
    }
}
