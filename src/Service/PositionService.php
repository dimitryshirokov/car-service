<?php

declare(strict_types=1);

namespace App\Service;


use App\Repository\PositionRepository;

/**
 * Class PositionService
 * @package App\Service
 */
class PositionService implements PositionServiceInterface
{
    /**
     * @var PositionRepository
     */
    private PositionRepository $positionRepository;

    /**
     * PositionService constructor.
     * @param PositionRepository $positionRepository
     */
    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    /**
     * @return array
     */
    public function getPositions(): array
    {
        return $this->getPositionRepository()->getPositions();
    }

    /**
     * @return PositionRepository
     */
    public function getPositionRepository(): PositionRepository
    {
        return $this->positionRepository;
    }
}
