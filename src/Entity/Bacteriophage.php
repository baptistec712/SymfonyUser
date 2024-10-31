<?php

namespace App\Entity;

use App\Repository\BacteriophageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BacteriophageRepository::class)]
class Bacteriophage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $nom = null;

    #[ORM\Column(length: 180)]
    private ?string $genre = null;

    #[ORM\Column(length: 180)]
    private ?string $souchePropagation = null;

    #[ORM\Column(length: 180)]
    private ?string $especeAttaque = null;


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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    public function getSouchePropagation(): ?string
    {
        return $this->souchePropagation;
    }

    public function setSouchePropagation(string $souchePropagation): self
    {
        $this->souchePropagation = $souchePropagation;
        return $this;
    }

    public function getEspeceAttaque(): ?string
    {
        return $this->especeAttaque;
    }

    public function setEspeceAttaque(string $especeAttaque): self
    {
        $this->especeAttaque = $especeAttaque;
        return $this;
    }
}
