<?php

declare(strict_types=1);

namespace App\Extractor;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\Order;

/**
 * Class CustomerExtractor
 * @package App\Extractor
 */
class CustomerExtractor implements ExtractorInterface
{
    /**
     * @param object|Customer $from
     * @return array
     */
    public function extract(object $from): array
    {
        $orders = $this->extractOrders($from->getOrders());
        $cars = $this->extractCars($from->getCars());

        return [
            'id' => $from->getId(),
            'surname' => $from->getSurname(),
            'name' => $from->getName(),
            'patronymic' => $from->getPatronymic(),
            'phone' => $from->getPhone(),
            'discount' => $from->getDiscount(),
            'orders' => $orders,
            'cars' => $cars,
        ];
    }

    /**
     * @param Order[] $orders
     * @return array
     */
    private function extractOrders($orders): array
    {
        $result = [];
        foreach ($orders as $order) {
            $result[] = [
                'id' => $order->getId(),
                'created' => $order->getCreated()->format('Y-m-d H:i:s'),
                'price' => $order->getPrice(),
                'totalPrice' => $order->getTotalPrice(),
                'status' => $order->getStatus(),
                'vin' => $order->getCar()->getVin(),
            ];
        }

        return $result;
    }

    /**
     * @param Car[] $cars
     * @return array
     */
    private function extractCars($cars): array
    {
        $result = [];
        foreach ($cars as $car) {
            $result[] = [
                'manufacturer' => $car->getManufacturer(),
                'model' => $car->getModel(),
                'engine' => $car->getEngine(),
                'vin' => $car->getVin(),
                'year' => $car->getYear(),
            ];
        }

        return $result;
    }
}
