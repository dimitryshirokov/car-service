<?php

declare(strict_types=1);

namespace App\Service;

/**
 * Interface ResumeServiceInterface
 * @package App\Service
 */
interface ResumeServiceInterface
{
    /**
     * @return array
     */
    public function getResume(): array;
}
