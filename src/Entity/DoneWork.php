<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DoneWork
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\DoneWorkRepository")
 */
class DoneWork
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @var Work
     * @ORM\ManyToOne(targetEntity="App\Entity\Work", inversedBy="doneWorks", cascade={"PERSIST"})
     * @ORM\JoinColumn(referencedColumnName="id", name="work_id")
     */
    private Work $work;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $countOfWork;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $price;

    /**
     * @var ArrayCollection|Employee[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Employee", inversedBy="doneWorks", cascade={"PERSIST"})
     * @ORM\JoinTable(name="done_works_employers")
     */
    private $employers;

    /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="doneWorks", cascade={"PERSIST"})
     * @ORM\JoinColumn(referencedColumnName="id", name="order_id")
     */
    private Order $order;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $active = true;

    public function __construct()
    {
        $this->employers = new ArrayCollection();
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
     * @return DoneWork
     */
    public function setId(int $id): DoneWork
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Work
     */
    public function getWork(): Work
    {
        return $this->work;
    }

    /**
     * @param Work $work
     * @return DoneWork
     */
    public function setWork(Work $work): DoneWork
    {
        $this->work = $work;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountOfWork(): string
    {
        return $this->countOfWork;
    }

    /**
     * @param string $countOfWork
     * @return DoneWork
     */
    public function setCountOfWork(string $countOfWork): DoneWork
    {
        $this->countOfWork = $countOfWork;
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
     * @return DoneWork
     */
    public function setPrice(string $price): DoneWork
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Employee[]|ArrayCollection
     */
    public function getEmployers()
    {
        return $this->employers;
    }

    /**
     * @param Employee[]|ArrayCollection $employers
     * @return DoneWork
     */
    public function setEmployers($employers)
    {
        $this->employers = $employers;
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
     * @return DoneWork
     */
    public function setOrder(Order $order): DoneWork
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return DoneWork
     */
    public function setActive(bool $active): DoneWork
    {
        $this->active = $active;
        return $this;
    }
}
