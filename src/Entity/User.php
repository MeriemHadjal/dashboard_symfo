<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Enfants", mappedBy="user", orphanRemoval=true)
     */
    private $enfants;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlanningResponse", mappedBy="user", orphanRemoval=true)
     */
    private $planningResponses;

    public function __construct()
    {
        $this->enfants = new ArrayCollection();
        $this->planningResponses = new ArrayCollection();
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
    public function getUsername(): string
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Enfants[]
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(Enfants $enfant): self
    {
        if (!$this->enfants->contains($enfant)) {
            $this->enfants[] = $enfant;
            $enfant->setUser($this);
        }

        return $this;
    }

    public function removeEnfant(Enfants $enfant): self
    {
        if ($this->enfants->contains($enfant)) {
            $this->enfants->removeElement($enfant);
            // set the owning side to null (unless already changed)
            if ($enfant->getUser() === $this) {
                $enfant->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom().' '.$this->getPrenom();
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
            $planningResponse->setUser($this);
        }

        return $this;
    }

    public function removePlanningResponse(PlanningResponse $planningResponse): self
    {
        if ($this->planningResponses->contains($planningResponse)) {
            $this->planningResponses->removeElement($planningResponse);
            // set the owning side to null (unless already changed)
            if ($planningResponse->getUser() === $this) {
                $planningResponse->setUser(null);
            }
        }

        return $this;
    }
}
