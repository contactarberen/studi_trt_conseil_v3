<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\ManyToOne(inversedBy: 'candidatureId')]
    private ?Annonce $annonceId = null;

    #[ORM\ManyToOne(inversedBy: 'candidatureId')]
    private ?User $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getAnnonceId(): ?Annonce
    {
        return $this->annonceId;
    }

    public function setAnnonceId(?Annonce $annonceId): self
    {
        $this->annonceId = $annonceId;

        return $this;
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
