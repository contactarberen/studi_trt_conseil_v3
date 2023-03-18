<?php

namespace App\Entity;

use App\Repository\DiplayedRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiplayedRoleRepository::class)]
class DiplayedRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'displayedRoleId', targetEntity: User::class)]
    private Collection $userId;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
    }

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

    
    public function __toString(){
        return $this->nom; // Remplacer champ par une propriété "string" de l'entité
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
            $userId->setDisplayedRoleId($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getDisplayedRoleId() === $this) {
                $userId->setDisplayedRoleId(null);
            }
        }

        return $this;
    }
}
