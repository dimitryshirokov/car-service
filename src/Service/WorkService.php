<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Position;
use App\Entity\Work;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class WorkService
 * @package App\Service
 */
class WorkService implements WorkServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * WorkService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @return Work
     */
    public function create(array $data): Work
    {
        $work = new Work();
        $work->setTitle($data['title'])
            ->setPrice($data['price']);

        $positionRepository = $this->getEntityManager()->getRepository(Position::class);
        $neededPositions = $work->getNeededPositions();
        foreach ($data['positions'] as $positionType) {
            $position = $positionRepository->findOneBy([
                'type' => $positionType,
            ]);
            $position->getWorks()->add($work);
            $neededPositions->add($position);
        }

        $work->setNeededPositions($neededPositions);
        $this->getEntityManager()->persist($work);
        $this->getEntityManager()->flush();

        $this->getEntityManager()->refresh($work);

        return $work;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit, int $offset): array
    {
        $workRepository = $this->getEntityManager()->getRepository(Work::class);
        $result = $workRepository->getWorks($limit, $offset);
        $count = $workRepository->getCountOfWorks();

        return [
            'result' => $result,
            'count' => $count,
            'countFiltered' => $count,
        ];
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
