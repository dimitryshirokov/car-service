<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    public const STATUS_NEW = 'new';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_DONE = 'done';
    public const STATUS_CANCELLED = 'cancelled';

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private DateTime $created;

    /**
     * @var ArrayCollection|DoneWork[]
     * @ORM\OneToMany(targetEntity="App\Entity\DoneWork", mappedBy="order", cascade={"PERSIST"})
     */
    private $doneWorks;

    /**
     * @var ArrayCollection|Part[]
     * @ORM\OneToMany(targetEntity="App\Entity\Part", mappedBy="order", cascade={"PERSIST"})
     */
    private $parts;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="orders", cascade={"PERSIST"})
     * @ORM\JoinColumn(referencedColumnName="id", name="customer_id")
     */
    private Customer $customer;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $price;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $totalPrice;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $status;

    /**
     * @var Car
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="orders")
     * @ORM\JoinColumn(referencedColumnName="id", name="car_id")
     */
    private Car $car;

    public function __construct()
    {
        $this->doneWorks = new ArrayCollection();
        $this->parts = new ArrayCollection();
        $this->status = self::STATUS_NEW;
        $this->created = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Order
     */
    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     * @return Order
     */
    public function setCreated(DateTime $created): Order
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return DoneWork[]|ArrayCollection
     */
    public function getDoneWorks()
    {
        return $this->doneWorks;
    }

    /**
     * @param DoneWork[]|ArrayCollection $doneWorks
     * @return Order
     */
    public function setDoneWorks($doneWorks)
    {
        $this->doneWorks = $doneWorks;
        return $this;
    }

    /**
     * @return Part[]|ArrayCollection
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * @param Part[]|ArrayCollection $parts
     * @return Order
     */
    public function setParts($parts)
    {
        $this->parts = $parts;
        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Order
     */
    public function setCustomer(Customer $customer): Order
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Order
     */
    public function setPrice(string $price): Order
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getTotalPrice(): string
    {
        return $this->totalPrice;
    }

    /**
     * @param string $totalPrice
     * @return Order
     */
    public function setTotalPrice(string $totalPrice): Order
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Order
     */
    public function setStatus(string $status): Order
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }

    /**
     * @param Car $car
     * @return Order
     */
    public function setCar(Car $car): Order
    {
        $this->car = $car;
        return $this;
    }
}
