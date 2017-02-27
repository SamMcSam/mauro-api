<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="DataBundle\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * Sunday Datetime
     *
     * @ORM\Column(name="week", type="datetime")
     */
    protected $week;

    /**
     * @ORM\OneToMany(targetEntity="Selection", mappedBy="menu")
     */
    protected $selections;

    public function __construct() {
        $this->selections = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set week
     *
     * @param \DateTime $week
     * @return Menu
     */
    public function setWeek($week)
    {
        $this->week = $week;

        return $this;
    }

    /**
     * Get week
     *
     * @return \DateTime
     */
    public function getWeek()
    {
        return $this->week;
    }

    public function addSelectionArray($selectionArray)
    {
      foreach($selectionArray as $selection) {
        $selection->setMenu($this);
        $this->selections->add($selection);
      }
    }
}
