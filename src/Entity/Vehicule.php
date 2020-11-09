<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caract;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="vehicules")
     */
    private $client;

    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;

    public function getId(): ?int {
        return $this->id;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getNb(): ?int {
        return $this->nb;
    }

    public function setNb(int $nb): self {
        $this->nb = $nb;

        return $this;
    }

    public function getCaract(): ?string {
        return $this->caract;
    }

    public function setCaract(string $caract): self {
        $this->caract = $caract;

        return $this;
    }

    public function getLocation(): ?string {
        return $this->location;
    }

    public function setLocation(string $location): self {
        $this->location = $location;

        return $this;
    }

    public function getPhoto(): ?string {
        return $this->photo;
    }

    public function setPhoto(string $photo): self {
        $this->photo = $photo;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }
}
