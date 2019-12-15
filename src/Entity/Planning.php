<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningRepository")
 */
class Planning
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\Column(type="date")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $DateFin;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Equipe", mappedBy="planning")
     * 
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlanningResponse", mappedBy="planning")
     */
    private $planningResponses;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->planningResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            
            $equipe->addPlanning($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->contains($equipe)) {
            $this->equipes->removeElement($equipe);
            $equipe->removePlanning($this);
        }

        return $this;
    }

    /**
     * @return Collection|PlanningResponse[]
     */
    public function getPlanningResponses(): Collection
    {
        return $this->planningResponses;
    }

    public function addPlanningResponse(PlanningResponse $planningResponse): self
    {
        if (!$this->planningResponses->contains($planningResponse)) {
            $this->planningResponses[] = $planningResponse;
            $planningResponse->setPlanning($this);
        }

        return $this;
    }

    public function removePlanningResponse(PlanningResponse $planningResponse): self
    {
        if ($this->planningResponses->contains($planningResponse)) {
            $this->planningResponses->removeElement($planningResponse);
            // set the owning side to null (unless already changed)
            if ($planningResponse->getPlanning() === $this) {
                $planningResponse->setPlanning(null);
            }
        }

        return $this;
    }
}
