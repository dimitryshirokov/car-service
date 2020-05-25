<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Position
 * @package App\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PositionRepository")
 */
class Position
{
    public const TYPE_CARCASS = 'carcass';
    public const TYPE_ELECTRICIAN = 'electrician';
    public const TYPE_LOCKSMITH = 'locksmith';
    public const TYPE_ELECTRONIC = 'electronic';

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
    private string $type;

    /**
     * @var ArrayCollection|Employee[]
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="position", cascade={"PERSIST"})
     */
    private $employers;

    /**
     * @var ArrayCollection|Work[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Work", inversedBy="neededPositions", cascade={"PERSIST"})
     */
    private $works;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Position
     */
    public function setId(int $id): Position
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
     * @return Position
     */
    public function setTitle(string $title): Position
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Position
     */
    public function setType(string $type): Position
    {
        $this->type = $type;
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
     * @return Position
     */
    public function setEmployers($employers)
    {
        $this->employers = $employers;
        return $this;
    }

    /**
     * @return Work[]|ArrayCollection
     */
    public function getWorks()
    {
        return $this->works;
    }

    /**
     * @param Work[]|ArrayCollection $works
     * @return Position
     */
    public function setWorks($works)
    {
        $this->works = $works;
        return $this;
    }

    /**
     * @param string $type
     * @return string
     */
    public static function translateType(string $type): string
    {
        $map = [
            self::TYPE_CARCASS => 'Кузовщик',
            self::TYPE_ELECTRICIAN => 'Электрик',
            self::TYPE_LOCKSMITH => 'Слесарь',
            self::TYPE_ELECTRONIC => 'Электроника',
        ];

        return $map[$type];
    }
}
