<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $week;

    /**
     * @ORM\OneToMany(targetEntity="Selection", mappedBy="menu")
     */
    protected $selections;

    public function __construct() {
        $this->selections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeek(): ?\DateTimeInterface
    {
        return $this->week;
    }

    public function setWeek(\DateTimeInterface $week): self
    {
        $this->week = $week;

        return $this;
    }

    public function addSelectionArray($selectionArray)
    {
        foreach($selectionArray as $selection) {
            $selection->setMenu($this);
            $this->selections->add($selection);
        }
    }
}
