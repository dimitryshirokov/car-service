<?php

declare(strict_types=1);

namespace App\Extractor;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\Order;

/**
 * Class CarExtractor
 * @package App\Extractor
 */
class CarExtractor implements ExtractorInterface
{
    /**
     * @param object|Car $from
     * @return array
     */
    public function extract(object $from): array
    {
        $orders = $this->extractOrders($from->getOrders());
        $customers = $this->extractCustomers($from->getCustomers());

        return [
            'id' => $from->getId(),
            'manufacturer' => $from->getManufacturer(),
            'model' => $from->getModel(),
            'vin' => $from->getVin(),
            'engine' => $from->getEngine(),
            'year' => $from->getYear(),
            'orders' => $orders,
            'customers' => $customers,
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
            ];
        }

        return $result;
    }

    /**
     * @param Customer[] $customers
     * @return array
     */
    private function extractCustomers($customers): array
    {
        $result = [];
        foreach ($customers as $customer) {
            $result[] = [
                'id' => $customer->getId(),
                'surname' => $customer->getSurname(),
                'name' => $customer->getName(),
                'patronymic' => $customer->getPatronymic(),
                'phone' => $customer->getPhone(),
                'discount' => $customer->getDiscount(),
            ];
        }

        return $result;
    }
}
