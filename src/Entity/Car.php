<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Car
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
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
    private string $manufacturer;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $model;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private string $vin;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $engine;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $year;

    /**
     * @var ArrayCollection|Customer[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", inversedBy="cars", cascade={"PERSIST"})
     */
    private $customers;

    /**
     * @var ArrayCollection|Order[]
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="car")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->customers = new ArrayCollection();
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
     * @return Car
     */
    public function setId(int $id): Car
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     * @return Car
     */
    public function setManufacturer(string $manufacturer): Car
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return Car
     */
    public function setModel(string $model): Car
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string
     */
    public function getVin(): string
    {
        return $this->vin;
    }

    /**
     * @param string $vin
     * @return Car
     */
    public function setVin(string $vin): Car
    {
        $this->vin = $vin;
        return $this;
    }

    /**
     * @return string
     */
    public function getEngine(): string
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     * @return Car
     */
    public function setEngine(string $engine): Car
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     * @return Car
     */
    public function setYear(string $year): Car
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return Customer[]|ArrayCollection
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param Customer[]|ArrayCollection $customers
     * @return Car
     */
    public function setCustomers($customers)
    {
        $this->customers = $customers;
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
     * @return Car
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
        return $this;
    }
}
