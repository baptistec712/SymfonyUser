<?php

namespace App\Entity;

use App\Repository\ConsortiaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsortiaRepository::class)]
class Consortia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_fromage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stade_prelevement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeFromage(): ?string
    {
        return $this->type_fromage;
    }

    public function setTypeFromage(?string $type_fromage): static
    {
        $this->type_fromage = $type_fromage;

        return $this;
    }

    public function getStadePrelevement(): ?string
    {
        return $this->stade_prelevement;
    }

    public function setStadePrelevement(?string $stade_prelevement): static
    {
        $this->stade_prelevement = $stade_prelevement;

        return $this;
    }
}
