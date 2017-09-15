<?php

namespace AppBundle\Entity;


/**
 * @ORM\Table(name="products")
 * @ORM\Entity()
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(name="date_was_created", type="string", length=50, unique=)
     * @Assert\NotBlank()
     */
    private $dateWasCreated;

    /**
     * @ORM\Column(name="date_last_change", type="string", length=50, unique=)
     * @Assert\NotBlank()
     */
    private $dateLastChange;

    /**
     * @ORM\Column(name="is_active", type="boolean", length=50, unique=)
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
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

}