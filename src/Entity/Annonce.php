<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitulePoste = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuTravail = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $horaires = null;

    #[ORM\Column]
    private ?int $salaire = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\ManyToOne(inversedBy: 'idAnnonce')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeContrat $idTypeContrat = null;

    #[ORM\ManyToOne(inversedBy: 'annonceId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\OneToMany(mappedBy: 'annonceId', targetEntity: Candidature::class)]
    private Collection $candidatureId;

    public function __construct()
    {
        $this->candidatureId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitulePoste(): ?string
    {
        return $this->intitulePoste;
    }

    public function setIntitulePoste(string $intitulePoste): self
    {
        $this->intitulePoste = $intitulePoste;

        return $this;
    }

    public function getLieuTravail(): ?string
    {
        return $this->lieuTravail;
    }

    public function setLieuTravail(string $lieuTravail): self
    {
        $this->lieuTravail = $lieuTravail;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHoraires(): ?string
    {
        return $this->horaires;
    }

    public function setHoraires(string $horaires): self
    {
        $this->horaires = $horaires;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(string $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getIdTypeContrat(): ?TypeContrat
    {
        return $this->idTypeContrat;
    }

    public function setIdTypeContrat(?TypeContrat $idTypeContrat): self
    {
        $this->idTypeContrat = $idTypeContrat;

        return $this;
    }
    public function __toString(){
        return $this->actif; // Remplacer champ par une propriété "string" de l'entité
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

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
            $candidatureId->setAnnonceId($this);
        }

        return $this;
    }

    public function removeCandidatureId(Candidature $candidatureId): self
    {
        if ($this->candidatureId->removeElement($candidatureId)) {
            // set the owning side to null (unless already changed)
            if ($candidatureId->getAnnonceId() === $this) {
                $candidatureId->setAnnonceId(null);
            }
        }

        return $this;
    }
}
