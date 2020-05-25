<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Work;

/**
 * Interface WorkServiceInterface
 * @package App\Service
 */
interface WorkServiceInterface
{
    /**
     * @param array $data
     * @return Work
     */
    public function create(array $data): Work;

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll(int $limit, int $offset): array;
}
