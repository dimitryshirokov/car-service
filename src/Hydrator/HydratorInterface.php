<?php

declare(strict_types=1);

namespace App\Hydrator;

/**
 * Interface HydratorInterface
 * @package App\Hydrator
 */
interface HydratorInterface
{
    /**
     * @param array $from
     * @param object $to
     */
    public function hydrate(array $from, object $to): void;
}
