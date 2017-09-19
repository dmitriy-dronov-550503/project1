<?php
//dev branch
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table(name="products")
 * @ORM\Entity()
 */
class Product
{
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDateWasCreated()
    {
        return $this->dateWasCreated;
    }

    /**
     * @return mixed
     */
    public function getDateLastChange()
    {
        return $this->dateLastChange;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getUniqueIdentifier()
    {
        return $this->uniqueIdentifier;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=191, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(name="description", length=1000, type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="date_was_created", type="datetimetz")
     * @Assert\NotBlank()
     */
    private $dateWasCreated;

    /**
     * @ORM\Column(name="date_last_change", type="datetimetz")
     * @Assert\NotBlank()
     */
    private $dateLastChange;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Assert\NotBlank()
     */
    private $isActive;

    /**
     * @ORM\Column(name="unique_identifier", type="integer")
     * @ORM\GeneratedValue(strategy="UUID")
     * @Assert\NotBlank()
     */
    private $uniqueIdentifier;

    /**
     * One Product has Many Attributes.
     * @ORM\OneToMany(targetEntity="Attribute", mappedBy="product")
     */
    private $attributes;

    /**
     * Many Products have One Category.
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * One Product has Many Products.
     * @ORM\OneToMany(targetEntity="Product", mappedBy="parent")
     */
    private $children;

    /**
     * Many Products have One Product.
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    public function __construct() {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
