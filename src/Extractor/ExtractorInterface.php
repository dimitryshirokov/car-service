<?php

declare(strict_types=1);

namespace App\Extractor;

/**
 * Interface ExtractorInterface
 * @package App\Extractor
 */
interface ExtractorInterface
{
    /**
     * @param object $from
     * @return array
     */
    public function extract(object $from): array;
}
