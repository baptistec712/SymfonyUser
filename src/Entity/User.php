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

    final public const ROLE_USER = 'ROLE_USER';
    final public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $nom = null;

    #[ORM\Column(type: 'json')]
    private $roles = [];

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

    public function getRoles(): array
    {
        $roles = $this->roles;

        // Garantir que tous les utilisateurs ont au moins le rôle ROLE_USER
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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


    // Méthode pour vérifier si l'utilisateur est un Admin
    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->getRoles(), true);
    }

    // Méthode pour vérifier si l'utilisateur est un User
    public function isUser(): bool
    {
        return in_array('ROLE_USER', $this->getRoles(), true);
    }

    // Méthode pour assigner le rôle Admin
    public function setAdmin(): self
    {
        if (!in_array('ROLE_ADMIN', $this->roles, true)) {
            $this->roles[] = 'ROLE_ADMIN';
        }

        return $this;
    }

    // Méthode pour assigner le rôle User
    public function setUser(): self
    {
        if (!in_array('ROLE_USER', $this->roles, true)) {
            $this->roles[] = 'ROLE_USER';
        }

        return $this;
    }
}
