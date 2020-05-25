<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\CustomerRepository;
use App\Repository\EmployeeRepository;
use App\Repository\OrderRepository;

/**
 * Class ResumeService
 * @package App\Service
 */
class ResumeService implements ResumeServiceInterface
{
    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    /**
     * @var CustomerRepository
     */
    private CustomerRepository $customerRepository;

    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;

    /**
     * ResumeService constructor.
     * @param OrderRepository $orderRepository
     * @param CustomerRepository $customerRepository
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        CustomerRepository $customerRepository,
        EmployeeRepository $employeeRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @return array
     */
    public function getResume(): array
    {
        return [
            'newOrders' => $this->getOrderRepository()->getCount(Order::STATUS_NEW),
            'inProgressOrders' => $this->getOrderRepository()->getCount(Order::STATUS_IN_PROGRESS),
            'customers' => $this->getCustomerRepository()->getCount(),
            'employers' => $this->getEmployeeRepository()->getAllCount(),
        ];
    }

    /**
     * @return OrderRepository
     */
    public function getOrderRepository(): OrderRepository
    {
        return $this->orderRepository;
    }

    /**
     * @return CustomerRepository
     */
    public function getCustomerRepository(): CustomerRepository
    {
        return $this->customerRepository;
    }

    /**
     * @return EmployeeRepository
     */
    public function getEmployeeRepository(): EmployeeRepository
    {
        return $this->employeeRepository;
    }
}
