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
    #[ORM\Column]
    private ?string $confirm = null;

    #[ORM\Column (nullable: true)]
    private ?bool $actif = null;

    #[ORM\ManyToOne(inversedBy: 'userId')]
    private ?DiplayedRole $displayedRoleId = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Annonce::class)]
    private Collection $annonceId;
  
    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: AttributsRecruteur::class)]
    private Collection $attrRecruteurId;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: AttributsCandidat::class)]
    private Collection $attrCandidatId;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Candidature::class)]
    private Collection $candidatureId;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
        $this->annonceId = new ArrayCollection();
        $this->attrCandidatId = new ArrayCollection();
        $this->attrRecruteurId = new ArrayCollection();
        $this->candidatureId = new ArrayCollection();
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

   
    /**
     * @return Collection<int, AttributsCandidat>
     */
    public function getAttrCandidatId(): Collection
    {
        return $this->attrCandidatId;
    }

    public function addAttrCandidatId(AttributsCandidat $attrCandidatId): self
    {
        if (!$this->attrCandidatId->contains($attrCandidatId)) {
            $this->attrCandidatId->add($attrCandidatId);
            $attrCandidatId->setUserId($this);
        }

        return $this;
    }

    public function removeAttrCandidatId(AttributsCandidat $attrCandidatId): self
    {
        if ($this->attrCandidatId->removeElement($attrCandidatId)) {
            // set the owning side to null (unless already changed)
            if ($attrCandidatId->getUserId() === $this) {
                $attrCandidatId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttributsCandidat>
     */
    public function getAttrRecruteurId(): Collection
    {
        return $this->attrRecruteurId;
    }

    public function addAttrRecruteurId(AttributsRecruteur $attrRecruteurId): self
    {
        if (!$this->attrRecruteurId->contains($attrRecruteurId)) {
            $this->attrRecruteurId->add($attrRecruteurId);
            $attrRecruteurId->setUserId($this);
        }

        return $this;
    }

    public function removeAttrRecruteurId(AttributsRecruteur $attrRecruteurId): self
    {
        if ($this->attrRecruteurId->removeElement($attrRecruteurId)) {
            // set the owning side to null (unless already changed)
            if ($attrRecruteurId->getUserId() === $this) {
                $attrRecruteurId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatureId(): Collection
    {
        return $this->candidatureId;
    }

    public function addCandidatureId(Candidature $candidatureId): self
    {
        if (!$this->candidatureId->contains($candidatureId)) {
            $this->candidatureId->add($candidatureId);
            $candidatureId->setUserId($this);
        }

        return $this;
    }

    public function removeCandidatureId(Candidature $candidatureId): self
    {
        if ($this->candidatureId->removeElement($candidatureId)) {
            // set the owning side to null (unless already changed)
            if ($candidatureId->getUserId() === $this) {
                $candidatureId->setUserId(null);
            }
        }

        return $this;
    }
}
