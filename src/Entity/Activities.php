<?php

namespace App\Entity;

use App\Repository\ActivitiesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=ActivitiesRepository::class)
 */
class Activities
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activities")
     */
    private $createBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activitiesUpdatedBy")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $chiffreAffaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pourcentage;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $activitePrincipale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valeurAjoutee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelleActivitePrincipale;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="activities")
     */
    private $repertoire;

    /**
     * @ORM\ManyToOne(targetEntity=SYSCOA::class, inversedBy="activite")
     */
    private $sYSCOA;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMA::class, inversedBy="activites")
     */
    private $nAEMA;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMAS::class, inversedBy="activites")
     */
    private $nAEMAS;

    /**
     * @ORM\ManyToOne(targetEntity=Citi::class, inversedBy="activites")
     */
    private $cITI;

      public function __construct()
    {
        $this->id = Uuid::v4();
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->activitePrincipale=false;
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

    public function getCreateBy(): ?User
    {
        return $this->createBy;
    }

    public function setCreateBy(?User $createBy): self
    {
        $this->createBy = $createBy;

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

    public function getChiffreAffaire(): ?string
    {
        return $this->chiffreAffaire;
    }

    public function setChiffreAffaire(?string $chiffreAffaire): self
    {
        $this->chiffreAffaire = $chiffreAffaire;

        return $this;
    }

    public function getPourcentage(): ?string
    {
        return $this->pourcentage;
    }

    public function setPourcentage(?string $pourcentage): self
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getActivitePrincipale(): ?bool
    {
        return $this->activitePrincipale;
    }

    public function setActivitePrincipale(?bool $activitePrincipale): self
    {
        $this->activitePrincipale = $activitePrincipale;

        return $this;
    }

    public function getValeurAjoutee(): ?string
    {
        return $this->valeurAjoutee;
    }

    public function setValeurAjoutee(?string $valeurAjoutee): self
    {
        $this->valeurAjoutee = $valeurAjoutee;

        return $this;
    }

    public function getLibelleActivitePrincipale(): ?string
    {
        return $this->libelleActivitePrincipale;
    }

    public function setLibelleActivitePrincipale(?string $libelleActivitePrincipale): self
    {
        $this->libelleActivitePrincipale = $libelleActivitePrincipale;

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

    public function getSYSCOA(): ?SYSCOA
    {
        return $this->sYSCOA;
    }

    public function setSYSCOA(?SYSCOA $sYSCOA): self
    {
        $this->sYSCOA = $sYSCOA;

        return $this;
    }

    public function getNAEMA(): ?NAEMA
    {
        return $this->nAEMA;
    }

    public function setNAEMA(?NAEMA $nAEMA): self
    {
        $this->nAEMA = $nAEMA;

        return $this;
    }

    public function getNAEMAS(): ?NAEMAS
    {
        return $this->nAEMAS;
    }

    public function setNAEMAS(?NAEMAS $nAEMAS): self
    {
        $this->nAEMAS = $nAEMAS;

        return $this;
    }

    public function getCITI(): ?CITI
    {
        return $this->cITI;
    }

    public function setCITI(?CITI $cITI): self
    {
        $this->cITI = $cITI;

        return $this;
    }
}
