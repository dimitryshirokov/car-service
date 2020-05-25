<?php

declare(strict_types=1);

namespace App\Extractor;

use App\Entity\DoneWork;
use App\Entity\Employee;
use App\Entity\Work;

/**
 * Class EmployeeExtractor
 * @package App\Extractor
 */
class EmployeeExtractor implements ExtractorInterface
{

    /**
     * @param object|Employee $from
     * @return array
     */
    public function extract(object $from): array
    {
        $doneWorks = $this->extractDoneWorks($from->getDoneWorks());
        $works = $this->extractWorks($from->getPosition()->getWorks());

        return [
            'id' => $from->getId(),
            'surname' => $from->getSurname(),
            'name' => $from->getName(),
            'patronymic' => $from->getPatronymic(),
            'startDate' => $from->getStartDate()->format('Y-m-d H:i:s'),
            'position' => $from->getPosition()->getTitle(),
            'positionType' => $from->getPosition()->getType(),
            'phone' => $from->getPhone(),
            'doneWorks' => $doneWorks,
            'works' => $works,
        ];
    }

    /**
     * @param DoneWork[] $doneWorks
     * @return array
     */
    private function extractDoneWorks($doneWorks): array
    {
        $result = [];
        foreach ($doneWorks as $doneWork) {
            if ($doneWork->isActive()) {
                $result[] = [
                    'title' => $doneWork->getWork()->getTitle(),
                    'orderId' => $doneWork->getOrder()->getId(),
                    'price' => $doneWork->getPrice(),
                    'hours' => $doneWork->getCountOfWork(),
                ];
            }
        }

        return $result;
    }

    /**
     * @param Work[] $works
     * @return array
     */
    private function extractWorks($works): array
    {
        $result = [];
        foreach ($works as $work) {
            $result[] = [
                'title' => $work->getTitle(),
                'price' => $work->getPrice(),
            ];
        }

        return $result;
    }
}
