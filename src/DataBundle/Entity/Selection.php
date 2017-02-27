<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use DataBundle\Util\Dow;

/**
 * Selection
 *
 * @ORM\Table(name="selection")
 * @ORM\Entity(repositoryClass="DataBundle\Repository\SelectionRepository")
 */
class Selection
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
     * @var int
     *
     * @ORM\Column(name="dow", type="integer")
     */
    protected $dow;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="selections")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", nullable=false)
     */
    protected $menu;

    /**
     * @ORM\ManyToMany(targetEntity="Dish")
     * @ORM\JoinTable(name="selection_dishes",
     *      joinColumns={@ORM\JoinColumn(name="selection_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="dish_id", referencedColumnName="id")}
     *      )
    */
    protected $dishes;

    public function __construct() {
        $this->dishes = new ArrayCollection();
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
     * Setter day of the week
     *
     * @var integer $dow
     * @return this
     */
    public function setDow($dow)
    {
        $this->dow = $dow;
        return $this;
    }

    /**
     * Get day of the week
     *
     * @return integer
     */
    public function getDow()
    {
        return $this->dow;
    }

    public function addDish(Dish $dish)
    {
      $this->dishes->add($dish);
      return $this;
    }

    public function getDishes()
    {
      return $this->dishes->toArray();
    }

    public function setMenu($menu)
    {
      $this->menu = $menu;
      return $this;
    }

    /**
    * @var EntityManager $em
    * @var array $selectionArray
    * @var boolean $persist
    * @return Selection
    */
    public static function generateFromArray(EntityManager $em, $selectionArray, $persist = true)
    {
      // @todo
      $selection = new Selection();

      //day
      $dayString = $selectionArray[0];
      $dayString = strtolower(trim(trim($dayString, ":")));

      $dow = Dow::$NAMEDAY_WEEK[$dayString];
      $selection->setDow($dow);

      // each item
      unset($selectionArray[0]);
      $repo = $em->getRepository("DataBundle:Dish");
      foreach ($selectionArray as $dishString) {
        $dishObject = $repo->findOneByName($dishString);
        if (is_null($dishObject)) {
          $dishObject = new Dish($dishString);
          if ($persist) {
            $em->persist($dishObject);
          }
        }
        $selection->addDish($dishObject);
      }

      if ($persist) {
        $em->persist($selection);
      }

      return $selection;
    }
}
