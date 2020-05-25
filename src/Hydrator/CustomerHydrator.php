<?php

declare(strict_types=1);

namespace App\Hydrator;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CustomerHydrator
 * @package App\Hydrator
 */
class CustomerHydrator implements HydratorInterface
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * CustomerHydrator constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $from
     * @param object $to
     * @throws ExceptionInterface
     */
    public function hydrate(array $from, object $to): void
    {
        unset($from['id']);
        $this->getSerializer()->denormalize(
            $from,
            get_class($to),
            null,
            [
                AbstractNormalizer::OBJECT_TO_POPULATE => $to,
            ]
        );
    }

    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }
}
