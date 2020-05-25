<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Work;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class WorkRepository
 * @package App\Repository
 * @method Work|null find($id, $lockMode = null, $lockVersion = null)
 * @method Work|null findOneBy(array $criteria, array $orderBy = null)
 * @method Work[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Work[] findAll()
 */
class WorkRepository extends ServiceEntityRepository
{
    /**
     * WorkRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Work::class);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getWorks(?int $limit, ?int $offset): array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();

        $query = $qb->select([
            'w.id',
            'w.title',
            'w.price',
            "GROUP_CONCAT(p.title) as positions",
            "GROUP_CONCAT(p.type) as positionTypes",
        ])->from('work', 'w')
            ->innerJoin('w', 'position_work', 'pw', 'w.id = pw.work_id')
            ->innerJoin('pw', 'position', 'p', 'pw.position_id = p.id')
            ->groupBy('w.id, w.title, w.price');

        if ($limit !== null && $offset !== null) {
            $query->setMaxResults($limit)
                ->setFirstResult($offset);
        }

        return $query->execute()->fetchAll();
    }

    /**
     * @return int
     */
    public function getCountOfWorks(): int
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();

        return (int) $qb->select('COUNT(w.id)')
            ->from('work', 'w')
            ->execute()
            ->fetchColumn();
    }
}
