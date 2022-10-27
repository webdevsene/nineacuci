<?php

namespace App\Entity;

use App\Repository\CuciImmoPlusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CuciImmoPlusRepository::class)
 * @ORM\Table(name="`cuci_immo_plus`")
 * 
 */
class CuciImmoPlus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cuciImmoPluses")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"persist"}, inversedBy="cuciImmoPlusesBy")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="updatedby", referencedColumnName="id")   
     * })  
     * 
     * */
    private $modifiedBy;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $amortPr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(type="string", length=1500, nullable=true)
     */
    private $brut;

   

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $net;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $valeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $refCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixCession;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="cuciImmoPluses")
     */
    private $repertoire;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $demat;

    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
         $this->id =uniqid();
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

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    public function getAmortPr(): ?string
    {
        return $this->amortPr;
    }

    public function setAmortPr(?string $amortPr): self
    {
        $this->amortPr = $amortPr;

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

   

    public function getNet(): ?string
    {
        return $this->net;
    }

    public function setNet(?string $net): self
    {
        $this->net = $net;

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

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(?string $valeur): self
    {
        $this->valeur = $valeur;

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

    public function getPrixCession(): ?string
    {
        return $this->prixCession;
    }

    public function setPrixCession(?string $prixCession): self
    {
        $this->prixCession = $prixCession;

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
