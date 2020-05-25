<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Work
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 */
class Work
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
     * @var ArrayCollection|Position[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Position", mappedBy="works", cascade={"PERSIST"})
     * @ORM\JoinTable(name="works_positions")
     */
    private $neededPositions;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private string $price;

    /**
     * @var ArrayCollection|DoneWork[]
     * @ORM\OneToMany(targetEntity="App\Entity\DoneWork", mappedBy="works", cascade={"PERSIST"})
     */
    private $doneWorks;

    public function __construct()
    {
        $this->neededPositions = new ArrayCollection();
        $this->doneWorks = new ArrayCollection();
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
     * @return Work
     */
    public function setId(int $id): Work
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
     * @return Work
     */
    public function setTitle(string $title): Work
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Position[]|ArrayCollection
     */
    public function getNeededPositions()
    {
        return $this->neededPositions;
    }

    /**
     * @param Position[]|ArrayCollection $neededPositions
     * @return Work
     */
    public function setNeededPositions($neededPositions)
    {
        $this->neededPositions = $neededPositions;
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
     * @return Work
     */
    public function setPrice(string $price): Work
    {
        $this->price = $price;
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
     * @return Work
     */
    public function setDoneWorks($doneWorks)
    {
        $this->doneWorks = $doneWorks;
        return $this;
    }
}
