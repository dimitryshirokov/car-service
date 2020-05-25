<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Interface PositionServiceInterface
 * @package App\Service
 */
interface PositionServiceInterface
{
    /**
     * @return array
     */
    public function getPositions(): array;
}
