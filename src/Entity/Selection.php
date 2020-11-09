<?php

namespace App\Entity;

use App\Model\Dow;
use App\Repository\SelectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=SelectionRepository::class)
 */
class Selection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $dow;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDow(): ?int
    {
        return $this->dow;
    }

    public function setDow(int $dow): self
    {
        $this->dow = $dow;

        return $this;
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
     * @return Selection
     *@var array $selectionArray
     * @var boolean $persist
     * @var EntityManager $em
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
        $repo = $em->getRepository(Dish::class);
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
