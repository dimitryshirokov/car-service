<?php

declare(strict_types=1);

namespace App\Hydrator;

use App\Entity\Car;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CarHydrator
 * @package App\Hydrator
 */
class CarHydrator implements HydratorInterface
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * CarHydrator constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $from
     * @param object|Car $to
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
