<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idC;

    /**
     * @ORM\Column(type="integer")
     */
    private $idV;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateD;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateF;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valeur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    public function getId(): ?int {
        return $this->id;
    }

    public function getIdC(): ?int {
        return $this->idC;
    }

    public function setIdC(int $idC): self {
        $this->idC = $idC;

        return $this;
    }

    public function getIdV(): ?int {
        return $this->idV;
    }

    public function setIdV(int $idV): self {
        $this->idV = $idV;

        return $this;
    }

    public function getDateD(): ?\DateTimeInterface {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface {
        return $this->dateF;
    }

    public function setDateF(\DateTimeInterface $dateF): self {
        $this->dateF = $dateF;

        return $this;
    }

    public function getValeur(): ?string {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self {
        $this->valeur = $valeur;

        return $this;
    }

    public function getEtat(): ?bool {
        return $this->etat;
    }

    public function setEtat(bool $etat): self {
        $this->etat = $etat;

        return $this;
    }
}
