<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Customer
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $surname;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $name;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $patronymic;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private string $phone;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $discount;

    /**
     * @var ArrayCollection|Car[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Car", mappedBy="customers", cascade={"PERSIST"})
     * @ORM\JoinTable(name="customers_cars")
     */
    private $cars;

    /**
     * @var ArrayCollection|Order[]
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="customer", cascade={"PERSIST"})
     */
    private $orders;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
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
     * @return Customer
     */
    public function setId(int $id): Customer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Customer
     */
    public function setSurname(string $surname): Customer
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName(string $name): Customer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param string|null $patronymic
     * @return Customer
     */
    public function setPatronymic(?string $patronymic): Customer
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscount(): string
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     * @return Customer
     */
    public function setDiscount(string $discount): Customer
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return Car[]|ArrayCollection
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * @param Car[]|ArrayCollection $cars
     * @return Customer
     */
    public function setCars($cars)
    {
        $this->cars = $cars;
        return $this;
    }

    /**
     * @return Order[]|ArrayCollection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param Order[]|ArrayCollection $orders
     * @return Customer
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
        return $this;
    }
}
