<?php

declare(strict_types=1);

namespace App\Hydrator;

use App\Entity\Employee;
use DateTime;
use Exception;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class EmployeeHydrator
 * @package App\Hydrator
 */
class EmployeeHydrator implements HydratorInterface
{
    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * EmployeeHydrator constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $from
     * @param object|Employee $to
     * @throws ExceptionInterface
     * @throws Exception
     */
    public function hydrate(array $from, object $to): void
    {
        unset($from['id']);
        $from['startDate'] = new DateTime($from['startDate']);
        $this->getSerializer()->denormalize(
            $from,
            Employee::class,
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
