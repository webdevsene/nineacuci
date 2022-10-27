<?php

namespace App\Entity;

use App\Repository\SuiviMaterielMobilierCautionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuiviMaterielMobilierCautionRepository::class)
 */
class SuiviMaterielMobilierCaution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="suiviMaterielMobilierCautions")
     */
    private $repertoire;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="suiviMaterielMobilierCautions")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="suiviMaterielMobiliersCautionsModifiedBy")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateJ;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDeSortie;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prixDeCession;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

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

    public function getAnneeFinanciere(): ?int
    {
        return $this->anneeFinanciere;
    }

    public function setAnneeFinanciere(?int $anneeFinanciere): self
    {
        $this->anneeFinanciere = $anneeFinanciere;

        return $this;
    }

    public function getDateJ(): ?\DateTimeInterface
    {
        return $this->dateJ;
    }

    public function setDateJ(?\DateTimeInterface $dateJ): self
    {
        $this->dateJ = $dateJ;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDeSortie(): ?\DateTimeInterface
    {
        return $this->dateDeSortie;
    }

    public function setDateDeSortie(?\DateTimeInterface $dateDeSortie): self
    {
        $this->dateDeSortie = $dateDeSortie;

        return $this;
    }

    public function getPrixDeCession(): ?string
    {
        return $this->prixDeCession;
    }

    public function setPrixDeCession(?string $prixDeCession): self
    {
        $this->prixDeCession = $prixDeCession;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isSubmit(): ?bool
    {
        return $this->submit;
    }
}
