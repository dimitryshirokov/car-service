<?php

declare(strict_types=1);

namespace App\Extractor;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\DoneWork;
use App\Entity\Order;
use App\Entity\Part;

/**
 * Class OrderExtractor
 * @package App\Extractor
 */
class OrderExtractor implements ExtractorInterface
{

    /**
     * @param object|Order $from
     * @return array
     */
    public function extract(object $from): array
    {
        $customer = $this->extractCustomer($from->getCustomer());
        $car = $this->extractCar($from->getCar());
        $doneWorks = $this->extractDoneWorks($from->getDoneWorks());
        $parts = $this->extractParts($from->getParts());

        return [
            'created' => $from->getCreated()->format('d.m.Y H:i:s'),
            'price' => $from->getPrice(),
            'status' => $from->getStatus(),
            'totalPrice' => $from->getTotalPrice(),
            'customer' => $customer,
            'car' => $car,
            'doneWorks' => $doneWorks,
            'parts' => $parts,
        ];
    }

    /**
     * @param Part[] $parts
     * @return array
     */
    private function extractParts($parts): array
    {
        $result = [];
        foreach ($parts as $part) {
            $result[] = [
                'title' => $part->getTitle(),
                'number' => $part->getPartNumber(),
                'cost' => $part->getCost(),
            ];
        }

        return $result;
    }

    /**
     * @param DoneWork[] $doneWorks
     * @return array
     */
    private function extractDoneWorks($doneWorks): array
    {
        $result = [];
        foreach ($doneWorks as $doneWork) {
            $employers = [];
            foreach ($doneWork->getEmployers() as $employer) {
                $employers[] = trim($employer->getFio());
            }
            $employers = implode(', ', $employers);
            $result[] = [
                'price' => $doneWork->getPrice(),
                'work' => $doneWork->getWork()->getTitle(),
                'hours' => $doneWork->getCountOfWork(),
                'employers' => $employers,
            ];
        }

        return $result;
    }

    /**
     * @param Car $car
     * @return array
     */
    private function extractCar(Car $car): array
    {
        return [
            'manufacturer' => $car->getManufacturer(),
            'model' => $car->getModel(),
            'vin' => $car->getVin(),
            'engine' => $car->getEngine(),
            'year' => $car->getYear(),
        ];
    }

    /**
     * @param Customer $customer
     * @return array
     */
    private function extractCustomer(Customer $customer): array
    {
        return [
            'surname' => $customer->getSurname(),
            'name' => $customer->getName(),
            'patronymic' => $customer->getPatronymic(),
            'phone' => $customer->getPhone(),
            'discount' => $customer->getDiscount(),
        ];
    }
}
