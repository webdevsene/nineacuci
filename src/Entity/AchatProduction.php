<?php

namespace App\Entity;

use App\Repository\AchatProductionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=AchatProductionRepository::class) 
 * @ORM\Table(name="`cuci_achats_du_production`")
 */
class AchatProduction
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qtyProduitDansEtat;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyAcheteeDansEtat;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyAcheteeHorsPays;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valProduitDansEtat;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valAcheteeDansPays;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valAcheteeHorsPays;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $variationDesStocks;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $unites;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="achatProductions")
     */
    private $repertoire;

    /**
     * @ORM\ManyToOne(targetEntity=AchatProductionUtil::class, inversedBy="achatProduction")
     */
    private $achatProductionUtil;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="achatProductions")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="achatProductionsUpdatedBy")
     */
    private $updatedBy;

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

    public function __toString()
    {
        return $this->submit;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQtyProduitDansEtat(): ?string
    {
        return $this->qtyProduitDansEtat;
    }

    public function setQtyProduitDansEtat(?string $qtyProduitDansEtat): self
    {
        $this->qtyProduitDansEtat = $qtyProduitDansEtat;

        return $this;
    }

    public function getQtyAcheteeDansEtat(): ?string
    {
        return $this->qtyAcheteeDansEtat;
    }

    public function setQtyAcheteeDansEtat(?string $qtyAcheteeDansEtat): self
    {
        $this->qtyAcheteeDansEtat = $qtyAcheteeDansEtat;

        return $this;
    }

    public function getQtyAcheteeHorsPays(): ?string
    {
        return $this->qtyAcheteeHorsPays;
    }

    public function setQtyAcheteeHorsPays(?string $qtyAcheteeHorsPays): self
    {
        $this->qtyAcheteeHorsPays = $qtyAcheteeHorsPays;

        return $this;
    }

    public function getValProduitDansEtat(): ?string
    {
        return $this->valProduitDansEtat;
    }

    public function setValProduitDansEtat(?string $valProduitDansEtat): self
    {
        $this->valProduitDansEtat = $valProduitDansEtat;

        return $this;
    }

    public function getValAcheteeDansPays(): ?string
    {
        return $this->valAcheteeDansPays;
    }

    public function setValAcheteeDansPays(?string $valAcheteeDansPays): self
    {
        $this->valAcheteeDansPays = $valAcheteeDansPays;

        return $this;
    }

    public function getValAcheteeHorsPays(): ?string
    {
        return $this->valAcheteeHorsPays;
    }

    public function setValAcheteeHorsPays(?string $valAcheteeHorsPays): self
    {
        $this->valAcheteeHorsPays = $valAcheteeHorsPays;

        return $this;
    }

    public function getVariationDesStocks(): ?string
    {
        return $this->variationDesStocks;
    }

    public function setVariationDesStocks(?string $variationDesStocks): self
    {
        $this->variationDesStocks = $variationDesStocks;

        return $this;
    }

    public function getUnites(): ?string
    {
        return $this->unites;
    }

    public function setUnites(?string $unites): self
    {
        $this->unites = $unites;

        return $this;
    }

    public function getAnneeFinanciere(): ?string
    {
        return $this->anneeFinanciere;
    }

    public function setAnneeFinanciere(?string $anneeFinanciere): self
    {
        $this->anneeFinanciere = $anneeFinanciere;

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

    public function getRepertoire(): ?Repertoire
    {
        return $this->repertoire;
    }

    public function setRepertoire(?Repertoire $repertoire): self
    {
        $this->repertoire = $repertoire;

        return $this;
    }

    public function getAchatProductionUtil(): ?AchatProductionUtil
    {
        return $this->achatProductionUtil;
    }

    public function setAchatProductionUtil(?AchatProductionUtil $achatProductionUtil): self
    {
        $this->achatProductionUtil = $achatProductionUtil;

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

    public function isSubmit(): ?bool
    {
        return $this->submit;
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
