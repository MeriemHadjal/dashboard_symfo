<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipeRepository")
 */
class Equipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Nom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Enfants", mappedBy="equipe", cascade={"persist", "remove"})
     */
    private $enfants;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Planning", inversedBy="equipes")
     */
    private $planning;

    public function __construct()
    {
        $this->planning = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getEnfants(): ?Enfants
    {
        return $this->enfants;
    }

    public function setEnfants(Enfants $enfants): self
    {
        $this->enfants = $enfants;

        // set the owning side of the relation if necessary
        if ($enfants->getEquipe() !== $this) {
            $enfants->setEquipe($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlanning(): Collection
    {
        return $this->planning;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->planning->contains($planning)) {
            $this->planning[] = $planning;
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->planning->contains($planning)) {
            $this->planning->removeElement($planning);
        }

        return $this;
    }
}
