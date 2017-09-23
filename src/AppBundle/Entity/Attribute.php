<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="attributes")
 * @ORM\Entity()
 */
class Attribute
{

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Many Attributes have One Product.
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="attributes")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $value;
}