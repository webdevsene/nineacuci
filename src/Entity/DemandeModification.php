<?php

namespace App\Entity;

use App\Repository\DemandeModificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeModificationRepository::class)
 */
class DemandeModification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="demandeModifications")
     */
    private $ninea;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class,cascade={"persist","remove"}, inversedBy="demandeModifications")
     */
    private $tempNinea;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demandeModifications")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demandeUpdatedBy")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $typeDemande;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateReactivation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ninlock;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNinea(): ?NINinea
    {
        return $this->ninea;
    }

    public function setNinea(?NINinea $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getTempNinea(): ?TempNINinea
    {
        return $this->tempNinea;
    }

    public function setTempNinea(?TempNINinea $tempNinea): self
    {
        $this->tempNinea = $tempNinea;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTypeDemande(): ?string
    {
        return $this->typeDemande;
    }

    public function setTypeDemande(?string $typeDemande): self
    {
        $this->typeDemande = $typeDemande;

        return $this;
    }

    public function getDateReactivation(): ?\DateTimeInterface
    {
        return $this->dateReactivation;
    }

    public function setDateReactivation(?\DateTimeInterface $dateReactivation): self
    {
        $this->dateReactivation = $dateReactivation;

        return $this;
    }

    public function isNinlock(): ?bool
    {
        return $this->ninlock;
    }

    public function setNinlock(?bool $ninlock): self
    {
        $this->ninlock = $ninlock;

        return $this;
    }
}
