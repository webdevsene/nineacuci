<?php

namespace App\Entity;

use App\Repository\ProductionDeExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ProductionDeExerciceRepository::class)
 * @ORM\Table(name="`cuci_production_de_exercice`")
 */
class ProductionDeExercice
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="productionDeExercices")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="productionDeExercicesUpBy")
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="productionDeExercices")
     */
    private $repertoire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $unites;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyProdVenduDansEtat;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valProdVenduDansEtat;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyProdVenduDansUemoa;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valProdVenduDansUemoa;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyProdVenduHorsUemoa;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valProdVenduHorsUemoa;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyProdImmobilisee;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valProdImmobilisee;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyStkOuverture;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valStkOuverture;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qtyStkCloture;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $valStkCloture;

    /**
     * @ORM\ManyToOne(targetEntity=ProductionDeExerciceUtil::class, inversedBy="productionDeExercices")
     */
    private $productionDeExerciceUtil;

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
        return $this->id;
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

    public function getAnneeFinanciere(): ?string
    {
        return $this->anneeFinanciere;
    }

    public function setAnneeFinanciere(?string $anneeFinanciere): self
    {
        $this->anneeFinanciere = $anneeFinanciere;

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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getSubmit(): ?string
    {
        return $this->submit;
    }

    public function setSubmit(?string $submit): self
    {
        $this->submit = $submit;

        return $this;
    }

    public function getQtyProdVenduDansEtat(): ?string
    {
        return $this->qtyProdVenduDansEtat;
    }

    public function setQtyProdVenduDansEtat(?string $qtyProdVenduDansEtat): self
    {
        $this->qtyProdVenduDansEtat = $qtyProdVenduDansEtat;

        return $this;
    }

    public function getValProdVenduDansEtat(): ?string
    {
        return $this->valProdVenduDansEtat;
    }

    public function setValProdVenduDansEtat(?string $valProdVenduDansEtat): self
    {
        $this->valProdVenduDansEtat = $valProdVenduDansEtat;

        return $this;
    }

    public function getQtyProdVenduDansUemoa(): ?string
    {
        return $this->qtyProdVenduDansUemoa;
    }

    public function setQtyProdVenduDansUemoa(?string $qtyProdVenduDansUemoa): self
    {
        $this->qtyProdVenduDansUemoa = $qtyProdVenduDansUemoa;

        return $this;
    }

    public function getValProdVenduDansUemoa(): ?string
    {
        return $this->valProdVenduDansUemoa;
    }

    public function setValProdVenduDansUemoa(?string $valProdVenduDansUemoa): self
    {
        $this->valProdVenduDansUemoa = $valProdVenduDansUemoa;

        return $this;
    }

    public function getQtyProdVenduHorsUemoa(): ?string
    {
        return $this->qtyProdVenduHorsUemoa;
    }

    public function setQtyProdVenduHorsUemoa(?string $qtyProdVenduHorsUemoa): self
    {
        $this->qtyProdVenduHorsUemoa = $qtyProdVenduHorsUemoa;

        return $this;
    }

    public function getValProdVenduHorsUemoa(): ?string
    {
        return $this->valProdVenduHorsUemoa;
    }

    public function setValProdVenduHorsUemoa(?string $valProdVenduHorsUemoa): self
    {
        $this->valProdVenduHorsUemoa = $valProdVenduHorsUemoa;

        return $this;
    }

    public function getQtyProdImmobilisee(): ?string
    {
        return $this->qtyProdImmobilisee;
    }

    public function setQtyProdImmobilisee(?string $qtyProdImmobilisee): self
    {
        $this->qtyProdImmobilisee = $qtyProdImmobilisee;

        return $this;
    }

    public function getValProdImmobilisee(): ?string
    {
        return $this->valProdImmobilisee;
    }

    public function setValProdImmobilisee(?string $valProdImmobilisee): self
    {
        $this->valProdImmobilisee = $valProdImmobilisee;

        return $this;
    }

    public function getQtyStkOuverture(): ?string
    {
        return $this->qtyStkOuverture;
    }

    public function setQtyStkOuverture(?string $qtyStkOuverture): self
    {
        $this->qtyStkOuverture = $qtyStkOuverture;

        return $this;
    }

    public function getValStkOuverture(): ?string
    {
        return $this->valStkOuverture;
    }

    public function setValStkOuverture(?string $valStkOuverture): self
    {
        $this->valStkOuverture = $valStkOuverture;

        return $this;
    }

    public function getQtyStkCloture(): ?string
    {
        return $this->qtyStkCloture;
    }

    public function setQtyStkCloture(?string $qtyStkCloture): self
    {
        $this->qtyStkCloture = $qtyStkCloture;

        return $this;
    }

    public function getValStkCloture(): ?string
    {
        return $this->valStkCloture;
    }

    public function setValStkCloture(?string $valStkCloture): self
    {
        $this->valStkCloture = $valStkCloture;

        return $this;
    }

    public function getProductionDeExerciceUtil(): ?ProductionDeExerciceUtil
    {
        return $this->productionDeExerciceUtil;
    }

    public function setProductionDeExerciceUtil(?ProductionDeExerciceUtil $productionDeExerciceUtil): self
    {
        $this->productionDeExerciceUtil = $productionDeExerciceUtil;

        return $this;
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
