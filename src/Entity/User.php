<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface, Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 320)]
    #[Assert\Email(message: "L'adresse e-mail n'est pas valide.")]
    #[Assert\NotBlank(message: "L'adresse e-mail est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 320,
        minMessage: "L'adresse e-mail doit contenir au moins {{ limit }} caractères.",
        maxMessage: "L'adresse e-mail ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(
        min: 6,
        max: 255,
        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le mot de passe ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Callback([self::class, 'validatePassword'])]
    private ?string $password = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le prénom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 10,
        max: 10,
        exactMessage: "Le numéro de téléphone doit contenir exactement {{ limit }} chiffres."
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: "L'URL GitHub n'est pas valide.")]
    private ?string $git = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(message: "L'URL LinkedIn n'est pas valide.")]
    private ?string $linkedin = null;

    #[Ignore] 
    #[Vich\UploadableField(mapping: 'cv', fileNameProperty: 'cvFilename')]
    #[Assert\File(
        maxSize: '10240k',
        mimeTypes: ['application/pdf'],
        maxSizeMessage: 'Le fichier ne doit pas dépasser 10Mo',
        mimeTypesMessage: 'Le fichier doit avoir une extension .pdf'
    )]
    private ?File $cv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cvFilename = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function eraseCredentials(): void {}

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getGit(): ?string
    {
        return $this->git;
    }

    public function setGit(?string $git): static
    {
        $this->git = $git;
        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): static
    {
        $this->linkedin = $linkedin;
        return $this;
    }

    public function getCv(): ?File
    {
        return $this->cv;
    }

    public function setCv(?File $cv = null): void
    {
        $this->cv = $cv;

        if ($cv) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCvFilename(): ?string
    {
        return $this->cvFilename;
    }

    public function setCvFilename(?string $cvFilename): static
    {
        $this->cvFilename = $cvFilename;
        return $this;
    }

    public function serialize(): string
    {
        return serialize([
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles,
            'password' => $this->password,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'telephone' => $this->telephone,
            'git' => $this->git,
            'linkedin' => $this->linkedin,
            'cvFilename' => $this->cvFilename,
            'updatedAt' => $this->updatedAt,
        ]);
    }

    public function unserialize(string $serialized): void
    {
        $data = unserialize($serialized);

        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->roles = $data['roles'];
        $this->password = $data['password'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->telephone = $data['telephone'];
        $this->git = $data['git'];
        $this->linkedin = $data['linkedin'];
        $this->cvFilename = $data['cvFilename'];
        $this->updatedAt = $data['updatedAt'];
    }

    public static function validatePassword(?string $password, ExecutionContextInterface $context): void
    {
        if ($password && !password_get_info($password)['algo']) {
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,255}$/', $password)) {
                $context->buildViolation("Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.")
                    ->atPath('password')
                    ->addViolation();
            }
        }
    }
}
