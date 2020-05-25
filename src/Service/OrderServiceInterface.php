<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;

/**
 * Interface OrderServiceInterface
 * @package App\Service
 */
interface OrderServiceInterface
{
    /**
     * @return array
     */
    public function getWorksAndEmployers(): array;

    /**
     * @param array $data
     * @return Order
     */
    public function createOrder(array $data): Order;

    /**
     * @param int $orderId
     * @return array
     */
    public function getOrder(int $orderId): array;

    /**
     * @param int $orderId
     * @param string $status
     * @return Order
     */
    public function changeOrderStatus(int $orderId, string $status): Order;

    /**
     * @param int $id
     * @return int|null
     */
    public function findOrder(int $id): ?int;

    /**
     * @param int $limit
     * @param int $offset
     * @param string $status
     * @return array
     */
    public function getOrders(int $limit, int $offset, string $status): array;
}
