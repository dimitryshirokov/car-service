<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Employee
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{
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
     * @var DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    private DateTime $startDate;

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
     * @ORM\Column(type="string", nullable=false)
     */
    private string $phone;

    /**
     * @var Position
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="employers", cascade={"PERSIST"})
     * @ORM\JoinColumn(referencedColumnName="id", name="position_id")
     */
    private Position $position;

    /**
     * @var ArrayCollection|DoneWork[]
     * @ORM\ManyToMany(targetEntity="App\Entity\DoneWork", mappedBy="employers", cascade={"PERSIST"})
     */
    private $doneWorks;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private bool $active = true;

    public function __construct()
    {
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
     * @return Employee
     */
    public function setId(int $id): Employee
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
     * @return Employee
     */
    public function setCreated(DateTime $created): Employee
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     * @return Employee
     */
    public function setStartDate(DateTime $startDate): Employee
    {
        $this->startDate = $startDate;
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
     * @return Employee
     */
    public function setSurname(string $surname): Employee
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
     * @return Employee
     */
    public function setName(string $name): Employee
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
     * @return Employee
     */
    public function setPatronymic(?string $patronymic): Employee
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
     * @return Employee
     */
    public function setPhone(string $phone): Employee
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     * @return Employee
     */
    public function setPosition(Position $position): Employee
    {
        $this->position = $position;
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
     * @return Employee
     */
    public function setDoneWorks($doneWorks)
    {
        $this->doneWorks = $doneWorks;
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
     * @return Employee
     */
    public function setActive(bool $active): Employee
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getFio(): string
    {
        return sprintf('%s %s %s', $this->getSurname(), $this->getName(), $this->getPatronymic());
    }
}
