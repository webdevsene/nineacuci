<?php

namespace App\Entity;

use App\Repository\BilanRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Table(name="`cuci_bilan`")
 * @ORM\Entity(repositoryClass=BilanRepository::class)
 */
class Bilan
{
     /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bilans")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bilansModifiedby")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $amortPR;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $brut;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="bilans")
     */
    private $repertoire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net2;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $refCode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $typeRecupperation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $uploadedFileName;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $demat;



    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
         $this->id = uniqid();
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

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

    public function getAmortPR(): ?string
    {
        return $this->amortPR;
    }

    public function setAmortPR(?string $amortPR): self
    {
        $this->amortPR = $amortPR;

        return $this;
    }

    public function getAnneeFinanciere(): ?int
    {
        return $this->anneeFinanciere;
    }

    public function setAnneeFinanciere(?int $anneeFinanciere): self
    {
        $this->anneeFinanciere = $anneeFinanciere;

        return $this;
    }

    public function getBrut(): ?string
    {
        return $this->brut;
    }

    public function setBrut(?string $brut): self
    {
        $this->brut = $brut;

        return $this;
    }

    public function getRepertoire(): ?Repertoire
    {
        return $this->repertoire;
    }

    public function setRepertoire(?Repertoire $repertoire): self
    {
        $this->repertoire = $repertoire;

        return $this;
    }

    public function getNet1(): ?string
    {
        return $this->net1;
    }

    public function setNet1(?string $net1): self
    {
        $this->net1 = $net1;

        return $this;
    }

    public function getNet2(): ?string
    {
        return $this->net2;
    }

    public function setNet2(?string $net2): self
    {
        $this->net2 = $net2;

        return $this;
    }

    public function getRefCode(): ?string
    {
        return $this->refCode;
    }

    public function setRefCode(?string $refCode): self
    {
        $this->refCode = $refCode;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSubmit(): ?bool
    {
        return $this->submit;
    }

    public function setSubmit(?bool $submit): self
    {
        $this->submit = $submit;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeRecupperation(): ?string
    {
        return $this->typeRecupperation;
    }

    public function setTypeRecupperation(?string $typeRecupperation): self
    {
        $this->typeRecupperation = $typeRecupperation;

        return $this;
    }

    public function getUploadedFileName(): ?string
    {
        return $this->uploadedFileName;
    }

    public function setUploadedFileName(?string $uploadedFileName): self
    {
        $this->uploadedFileName = $uploadedFileName;

        return $this;
    }

    public function isSubmit(): ?bool
    {
        return $this->submit;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    public function isDemat(): ?bool
    {
        return $this->demat;
    }

    public function setDemat(?bool $demat): self
    {
        $this->demat = $demat;

        return $this;
    }

}
