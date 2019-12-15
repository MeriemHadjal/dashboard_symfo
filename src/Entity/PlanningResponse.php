<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlanningResponseRepository")
 */
class PlanningResponse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $placeDisponible;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $present = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Planning", inversedBy="planningResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $planning;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="planningResponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $enfants = [];

    public function __construct()
    {
 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceDisponible(): ?int
    {
        return $this->placeDisponible;
    }

    public function setPlaceDisponible(?int $placeDisponible): self
    {
        $this->placeDisponible = $placeDisponible;

        return $this;
    }

    public function getPresent(): ?array
    {
        return $this->present;
    }

    public function setPresent(?array $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEnfants(): ?array
    {
        return $this->enfants;
    }

    public function setEnfants(?array $enfants): self
    {
        $this->enfants = $enfants;

        return $this;
    }
}
