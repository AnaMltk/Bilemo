<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Serializer\XmlRoot("product")
 * @Hateoas\Relation("self", href = "expr('/api/products/' ~ object.getId())")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\XmlAttribute
     * @Serializer\Groups({"list_product"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_product"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"list_product"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Serializer\Groups({"list_product"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_product"})
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
