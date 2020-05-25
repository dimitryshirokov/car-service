<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Part
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PartRepository")
 */
class Part
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
    private string $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $partNumber;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $cost;

    /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="parts", cascade={"PERSIST"})
     * @ORM\JoinColumn(referencedColumnName="id", name="order_id")
     */
    private Order $order;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Part
     */
    public function setId(int $id): Part
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Part
     */
    public function setTitle(string $title): Part
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getPartNumber(): string
    {
        return $this->partNumber;
    }

    /**
     * @param string $partNumber
     * @return Part
     */
    public function setPartNumber(string $partNumber): Part
    {
        $this->partNumber = $partNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCost(): string
    {
        return $this->cost;
    }

    /**
     * @param string $cost
     * @return Part
     */
    public function setCost(string $cost): Part
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return Part
     */
    public function setOrder(Order $order): Part
    {
        $this->order = $order;
        return $this;
    }
}
