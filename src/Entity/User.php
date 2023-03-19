<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    private ?string $confirm = null;

    #[ORM\ManyToOne(inversedBy: 'userId')]
    private ?DiplayedRole $displayedRoleId = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Annonce::class)]
    private Collection $annonceId;

    #[ORM\Column (nullable: true)]
    private ?bool $actif = null;

    #[ORM\OneToOne(inversedBy: 'userId', cascade: ['persist', 'remove'])]
    private ?AttributsCandidat $attrCandidatId = null;

    #[ORM\OneToOne(inversedBy: 'userId', cascade: ['persist', 'remove'])]
    private ?AttributsRecruteur $attrRecruteurId = null;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
        $this->annonceId = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $this->passwordHasher->hashPassword($this,$password);
        return $this;
    }

    /**
    * Get the value of confirm
     */
	public function getConfirm()
                      {
                          return $this->confirm;
                      }
	
	/**
	 * Set the value of confirm
	 *
	 * @return  self
	 */
	public function setConfirm($confirm)
                      {
                          $this->confirm = $confirm;
                      
                          return $this;
                      }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString(){
        return $this->email; // Remplacer champ par une propriété "string" de l'entité
    }

    public function getDisplayedRoleId(): ?DiplayedRole
    {
        return $this->displayedRoleId;
    }

    public function setDisplayedRoleId(?DiplayedRole $displayedRoleId): self
    {
        $this->displayedRoleId = $displayedRoleId;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonceId(): Collection
    {
        return $this->annonceId;
    }

    public function addAnnonceId(Annonce $annonceId): self
    {
        if (!$this->annonceId->contains($annonceId)) {
            $this->annonceId->add($annonceId);
            $annonceId->setUserId($this);
        }

        return $this;
    }

    public function removeAnnonceId(Annonce $annonceId): self
    {
        if ($this->annonceId->removeElement($annonceId)) {
            // set the owning side to null (unless already changed)
            if ($annonceId->getUserId() === $this) {
                $annonceId->setUserId(null);
            }
        }

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getAttrCandidatId(): ?AttributsCandidat
    {
        return $this->attrCandidatId;
    }

    public function setAttrCandidatId(?AttributsCandidat $attrCandidatId): self
    {
        $this->attrCandidatId = $attrCandidatId;

        return $this;
    }

    public function getAttrRecruteurId(): ?AttributsRecruteur
    {
        return $this->attrRecruteurId;
    }

    public function setAttrRecruteurId(?AttributsRecruteur $attrRecruteurId): self
    {
        $this->attrRecruteurId = $attrRecruteurId;

        return $this;
    }
}
