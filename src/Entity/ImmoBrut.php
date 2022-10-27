<?php

namespace App\Entity;

use App\Repository\ImmoBrutRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * 
 * @ORM\Entity(repositoryClass=ImmoBrutRepository::class)
 * @ORM\Table(name="cuci_immo_brut")
 */
class ImmoBrut
{
     /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="immoBruts")
     */
    private $createdby;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="immoBrutBy")
     */
    private $modifiedby;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $augmentationB1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $augmentationB2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $augmentationB3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brutA;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brutD;

  

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diminutionC1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $diminutionC2;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $refCode;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="immoBruts")
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

    public function getCreatedby(): ?User
    {
        return $this->createdby;
    }

    public function setCreatedby(?User $createdby): self
    {
        $this->createdby = $createdby;

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

    public function getModifiedby(): ?User
    {
        return $this->modifiedby;
    }

    public function setModifiedby(?User $modifiedby): self
    {
        $this->modifiedby = $modifiedby;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

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

    public function getAugmentationB1(): ?string
    {
        return $this->augmentationB1;
    }

    public function setAugmentationB1(?string $augmentationB1): self
    {
        $this->augmentationB1 = $augmentationB1;

        return $this;
    }

    public function getAugmentationB2(): ?string
    {
        return $this->augmentationB2;
    }

    public function setAugmentationB2(?string $augmentationB2): self
    {
        $this->augmentationB2 = $augmentationB2;

        return $this;
    }

    public function getAugmentationB3(): ?string
    {
        return $this->augmentationB3;
    }

    public function setAugmentationB3(?string $augmentationB3): self
    {
        $this->augmentationB3 = $augmentationB3;

        return $this;
    }

    public function getBrutA(): ?string
    {
        return $this->brutA;
    }

    public function setBrutA(?string $brutA): self
    {
        $this->brutA = $brutA;

        return $this;
    }

    public function getBrutD(): ?string
    {
        return $this->brutD;
    }

    public function setBrutD(?string $brutD): self
    {
        $this->brutD = $brutD;

        return $this;
    }

  

    public function getDiminutionC1(): ?string
    {
        return $this->diminutionC1;
    }

    public function setDiminutionC1(?string $diminutionC1): self
    {
        $this->diminutionC1 = $diminutionC1;

        return $this;
    }

    public function getDiminutionC2(): ?string
    {
        return $this->diminutionC2;
    }

    public function setDiminutionC2(?string $diminutionC2): self
    {
        $this->diminutionC2 = $diminutionC2;

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

    public function getSubmit(): ?bool
    {
        return $this->submit;
    }

    public function setSubmit(?bool $submit): self
    {
        $this->submit = $submit;

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
