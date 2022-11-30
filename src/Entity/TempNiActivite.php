<?php

namespace App\Entity;

use App\Repository\TempNiActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiActiviteRepository::class)
 */
class TempNiActivite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninAutact;


    /**
     * @ORM\ManyToOne(targetEntity=NAEMA::class, inversedBy="tempNiActivites")
     */
    private $refNaema;

   

   

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiActivites")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiActivites")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

   
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statActivprincipale;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class, inversedBy="tempNiActivites")
     */
    private $niNinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDeCloture;



    

    public function getId(): ?string
    {
        return $this->id;
    }

    
    public function __construct()
    {
        $this->id = uniqid();
    }

    public function getNinAutact(): ?string
    {
        return $this->ninAutact;
    }

    public function setNinAutact(?string $ninAutact): self
    {
        $this->ninAutact = $ninAutact;

        return $this;
    }

   

    public function getRefNaema(): ?NAEMA
    {
        return $this->refNaema;
    }

    public function setRefNaema(?NAEMA $refNaema): self
    {
        $this->refNaema = $refNaema;

        return $this;
    }

   

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

   

    public function isStatActivprincipale(): ?bool
    {
        return $this->statActivprincipale;
    }

    public function setStatActivprincipale(?bool $statActivprincipale): self
    {
        $this->statActivprincipale = $statActivprincipale;

        return $this;
    }

    public function getNiNinea(): ?TempNINinea
    {
        return $this->niNinea;
    }

    public function setNiNinea(?TempNINinea $niNinea): self
    {
        $this->niNinea = $niNinea;

        return $this;
    }

    public function getDateDeCloture(): ?\DateTimeInterface
    {
        return $this->DateDeCloture;
    }

    public function setDateDeCloture(?\DateTimeInterface $DateDeCloture): self
    {
        $this->DateDeCloture = $DateDeCloture;

        return $this;
    }

}
