<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
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

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'idAnnonce')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeContrat $idTypeContrat = null;

    #[ORM\ManyToOne(inversedBy: 'annonceId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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
        return $this->etat; // Remplacer champ par une propriété "string" de l'entité
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
}
