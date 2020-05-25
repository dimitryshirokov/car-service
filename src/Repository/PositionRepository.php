<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PositionRepository
 * @package App\Repository
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Position[] findAll()
 */
class PositionRepository extends ServiceEntityRepository
{
    /**
     * PositionRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    /**
     * @return array
     */
    public function getPositions(): array
    {
        $qb = $this->getEntityManager()->getConnection()->createQueryBuilder();

        return $qb->select([
            'p.title',
            'p.type'
        ])->from('position', 'p')
            ->execute()->fetchAll();
    }
}
