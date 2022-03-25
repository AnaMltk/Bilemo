<?php

namespace App\Entity;

use App\Entity\Client;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *  fields="email",
 *  message="Un utilisateur avec cet email existe déjà"
 * )
 * @ORM\Table(name="`user`")
 * @Hateoas\Relation(
 *      name = "self",
 *      href = @Hateoas\Route(
 *          "client_user_details",
 *          parameters = {
 *              "id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())"
 *          },
 *          absolute = true
 *      ),
 *      attributes = {"actions": { "read": "GET", "post": "POST", "delete": "DELETE" }},
 *      exclusion = @Hateoas\Exclusion(groups = {"list_user"})
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list_user"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client",inversedBy="users")
     * @ORM\JoinColumn(name="client_id",referencedColumnName="id")
     * @Serializer\Exclude
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_user"})
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_user"})
     * @Assert\Email(
     *     message = "The email is not a valid email."
     * )
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
