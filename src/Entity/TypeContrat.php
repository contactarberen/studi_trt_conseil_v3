<?php

namespace App\Entity;

use App\Repository\TypeContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeContratRepository::class)]
class TypeContrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomContrat = null;

    #[ORM\OneToMany(mappedBy: 'idTypeContrat', targetEntity: Annonce::class)]
    private Collection $idAnnonce;

    public function __construct()
    {
        $this->idAnnonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomContrat(): ?string
    {
        return $this->nomContrat;
    }

    public function setNomContrat(string $nomContrat): self
    {
        $this->nomContrat = $nomContrat;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getIdAnnonce(): Collection
    {
        return $this->idAnnonce;
    }

    public function addIdAnnonce(Annonce $idAnnonce): self
    {
        if (!$this->idAnnonce->contains($idAnnonce)) {
            $this->idAnnonce->add($idAnnonce);
            $idAnnonce->setIdTypeContrat($this);
        }

        return $this;
    }

    public function removeIdAnnonce(Annonce $idAnnonce): self
    {
        if ($this->idAnnonce->removeElement($idAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($idAnnonce->getIdTypeContrat() === $this) {
                $idAnnonce->setIdTypeContrat(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->nomContrat; // Remplacer champ par une propriété "string" de l'entité
    }
}
