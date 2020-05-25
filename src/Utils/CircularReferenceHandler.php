<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Class CircularReferenceHandler
 * @package App\Utils
 */
class CircularReferenceHandler
{
    /**
     * @param mixed $object
     * @return mixed
     */
    public function __invoke($object)
    {
        return $object->getId();
    }
}
