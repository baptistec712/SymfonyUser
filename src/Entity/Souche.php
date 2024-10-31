<?php

namespace App\Entity;

use App\Repository\SoucheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SoucheRepository::class)]
class Souche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $nom = null;

    #[ORM\Column(length: 180)]
    private ?string $nomPresouche = null;

    #[ORM\Column(length: 180)]
    private ?string $espece = null;


    #[ORM\Column(length: 180)]
    private ?string $sousEspeces = null;


    #[ORM\Column(length: 180)]
    private ?string $genre = null;

    #[ORM\Column(length: 180)]
    private ?string $biovar = null;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNomPresouche(): ?string
    {
        return $this->nomPresouche;
    }

    public function setNomPresouche(?string $nomPresouche): self
    {
        $this->nomPresouche = $nomPresouche;
        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;
        return $this;
    }

    public function getSousEspeces(): ?string
    {
        return $this->sousEspeces;
    }

    public function setSousEspeces(?string $sousEspeces): self
    {
        $this->sousEspeces = $sousEspeces;
        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    public function getBiovar(): ?string
    {
        return $this->biovar;
    }

    public function setBiovar(?string $biovar): self
    {
        $this->biovar = $biovar;
        return $this;
    }
}
