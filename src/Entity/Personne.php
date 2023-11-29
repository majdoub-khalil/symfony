<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\PersonneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Nom cannot be blank.')]
    #[Assert\Regex(pattern: "/^[a-zA-Z]+$/", message: 'Invalid characters in Nom.')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Prenom cannot be blank.')]
    #[Assert\Regex(pattern: "/^[a-zA-Z]+$/", message: 'Invalid characters in Prenom.')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Email cannot be blank.')]
    #[Assert\Email(message: 'Invalid email format.')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Date de Naissance cannot be blank.')]
    #[Assert\LessThan('today', message: 'Invalid date of birth.')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Mot de Passe cannot be blank.')]
    #[Assert\Length(min: 6, minMessage: 'Mot de Passe must be at least {{ limit }} characters long.')]
    private ?string $motDePasse = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Mot de Passe2 cannot be blank.')]
    #[Assert\EqualTo(propertyPath: 'motDePasse', message: 'Mot de Passe2 must be equal to Mot de Passe.')]
    private ?string $motDePasse2 = null;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getMotDePasse2(): ?string
    {
        return $this->motDePasse2;
    }

    public function setMotDePasse2(string $motDePasse2): static
    {
        $this->motDePasse2 = $motDePasse2;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email; // Replace with the actual field used as the username
    }

    public function getRoles(): array
    {
        return ['ROLE_USER']; // Define user roles based on your application logic
    }

    public function getPassword(): string
    {
        return $this->motDePasse; // Replace with the actual field used as the password
    }

    public function getSalt(): ?string
    {
        // You can leave this method blank unless you're using advanced user checking features.
        return null;
    }

    public function eraseCredentials(): void
    {
        // You can leave this method blank unless you're storing sensitive information.
    }

    public function getUsername(): string
    {
        return $this->email; // Replace with the actual field used as the username
    }
}
