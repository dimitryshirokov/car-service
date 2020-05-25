<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CustomerRepository
 * @package App\Repository
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Customer[] findAll()
 */
class CustomerRepository extends ServiceEntityRepository
{
    /**
     * CustomerRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */
    public function getCustomers(?int $limit, ?int $offset): array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();
        $expr = $qb->expr();

        $lastOrderDateQb = clone $qb;
        $lastOrderIdQb = clone $qb;

        $lastOrderDateQuery = $lastOrderDateQb->select('o.created')
            ->from('orders', 'o')
            ->where($expr->eq('o.customer_id', 'c.id'))
            ->orderBy('o.created', 'DESC')
            ->setMaxResults(1);

        $lastOrderIdQuery = $lastOrderIdQb->select('o.id')
            ->from('orders', 'o')
            ->where($expr->eq('o.customer_id', 'c.id'))
            ->orderBy('o.created', 'DESC')
            ->setMaxResults(1);

        $query = $qb->select([
            'c.id',
            "CONCAT_WS(' ', c.surname, c.name, c.patronymic) as fio",
            'c.phone',
            'c.discount',
            '(' . $lastOrderDateQuery->getSQL() . ') as lastOrderDate',
            '(' . $lastOrderIdQuery->getSQL() . ') as lastOrderId',
        ])->from('customer', 'c');

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
            ->from('customer', 'c')
            ->execute()
            ->fetchColumn();
    }
}
