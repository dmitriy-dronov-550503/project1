<?php

namespace AppBundle\Entity;


/**
 * @ORM\Table(name="products")
 * @ORM\Entity()
 */
class Product
{
    private $name;
    private $price;
    private $description;
}