<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DoneWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class DoneWorkRepository
 * @package App\Repository
 * @method DoneWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoneWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoneWork[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method DoneWork[] findAll()
 */
class DoneWorkRepository extends ServiceEntityRepository
{
    /**
     * DoneWorkRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoneWork::class);
    }
}
