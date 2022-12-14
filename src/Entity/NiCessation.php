<?php

namespace App\Entity;

use App\Repository\NiCessationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiCessationRepository::class)
 */
class NiCessation
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCessation;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="niCessations")
     */
    private $ninea;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="niCessations")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="niCessationeditbys")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $remarque;

    /**
     * @ORM\ManyToOne(targetEntity=NiTypeConsequence::class, inversedBy="niCessations")
     */
    private $ninConsequences;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ninlock;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $consequences;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $denominationBeneficiaire;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adresseBeneficiaire;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $rccmBeneficiaire;


    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
       
        
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
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

    public function getDateCessation(): ?\DateTimeInterface
    {
        return $this->dateCessation;
    }

    public function setDateCessation(?\DateTimeInterface $dateCessation): self
    {
        $this->dateCessation = $dateCessation;

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

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getNinConsequences(): ?NiTypeConsequence
    {
        return $this->ninConsequences;
    }

    public function setNinConsequences(?NiTypeConsequence $ninConsequences): self
    {
        $this->ninConsequences = $ninConsequences;

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

    public function getConsequences(): ?string
    {
        return $this->consequences;
    }

    public function setConsequences(?string $consequences): self
    {
        $this->consequences = $consequences;

        return $this;
    }

    public function getDenominationBeneficiaire(): ?string
    {
        return $this->denominationBeneficiaire;
    }

    public function setDenominationBeneficiaire(?string $denominationBeneficiaire): self
    {
        $this->denominationBeneficiaire = $denominationBeneficiaire;

        return $this;
    }

    public function getAdresseBeneficiaire(): ?string
    {
        return $this->adresseBeneficiaire;
    }

    public function setAdresseBeneficiaire(?string $adresseBeneficiaire): self
    {
        $this->adresseBeneficiaire = $adresseBeneficiaire;

        return $this;
    }

    public function getRccmBeneficiaire(): ?string
    {
        return $this->rccmBeneficiaire;
    }

    public function setRccmBeneficiaire(?string $rccmBeneficiaire): self
    {
        $this->rccmBeneficiaire = $rccmBeneficiaire;

        return $this;
    }


}
