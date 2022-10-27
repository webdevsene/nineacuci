<?php

namespace App\Entity;

use App\Repository\EtatDesStocksSmtRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=EtatDesStocksSmtRepository::class)
 * @ORM\Table(name="`cuci_etat_des_stocks_smt`")
 */
class EtatDesStocksSmt
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="etatDesStocksSmts")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="etatDesStocksSmtsUpdatedBy")
     */
    private $updatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="etatDesStocksSmts")
     */
    private $repertoire;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prixUnitaire;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=EtatDesStocksSmtUtil::class, inversedBy="etatDesStocksSmts")
     */
    private $etatDesStocksSmtUtil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valStockFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valStockInit;



    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->id = uniqid();
    }

    public function __toString()
    {
        return $this->id;
    }


    public function getId(): ?string
    {
        return $this->id;
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

    public function getRepertoire(): ?Repertoire
    {
        return $this->repertoire;
    }

    public function setRepertoire(?Repertoire $repertoire): self
    {
        $this->repertoire = $repertoire;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

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

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(?string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(?string $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

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

    public function getEtatDesStocksSmtUtil(): ?EtatDesStocksSmtUtil
    {
        return $this->etatDesStocksSmtUtil;
    }

    public function setEtatDesStocksSmtUtil(?EtatDesStocksSmtUtil $etatDesStocksSmtUtil): self
    {
        $this->etatDesStocksSmtUtil = $etatDesStocksSmtUtil;

        return $this;
    }

    public function isSubmit(): ?bool
    {
        return $this->submit;
    }

    public function getValStockFin(): ?string
    {
        return $this->valStockFin;
    }

    public function setValStockFin(?string $valStockFin): self
    {
        $this->valStockFin = $valStockFin;

        return $this;
    }

    public function getValStockInit(): ?string
    {
        return $this->valStockInit;
    }

    public function setValStockInit(?string $valStockInit): self
    {
        $this->valStockInit = $valStockInit;

        return $this;
    }
}
