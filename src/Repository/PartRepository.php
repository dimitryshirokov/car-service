<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Part;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PartRepository
 * @package App\Repository
 * @method Part|null find($id, $lockMode = null, $lockVersion = null)
 * @method Part|null findOneBy(array $criteria, array $orderBy = null)
 * @method Part[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Part[] findAll()
 */
class PartRepository extends ServiceEntityRepository
{
    /**
     * PartRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Part::class);
    }
}
