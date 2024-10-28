<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_NOM', fields: ['nom'])]
#[UniqueEntity(fields: ['nom'], message: 'There is already an account with this nom')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $nom = null;

    // Propriété pour indiquer si l'utilisateur est admin
    #[ORM\Column(type: 'boolean')]
    private bool $role = false; // false pour utilisateur standard, true pour admin

    #[ORM\Column]
    private ?string $password = null;

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

    public function getUserIdentifier(): string
    {
        return (string) $this->nom;
    }

    // Retourne le rôle sous forme de tableau
    public function getRoles(): array
    {
        return $this->role ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getRole(): bool
    {
        return $this->role; // Getter pour le rôle
    }

    public function setRole(bool $role): static
    {
        $this->role = $role; // Setter pour le rôle

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si tu stockes des données sensibles temporaires, efface-les ici
    }
}
