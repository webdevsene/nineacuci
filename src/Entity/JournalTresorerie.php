<?php

namespace App\Entity;

use App\Repository\JournalTresorerieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=JournalTresorerieRepository::class)
 * @ORM\Table(name="`cuci_journal_de_tresorerie_smt`")
 */
class JournalTresorerie
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
     * @ORM\Column( type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="journalTresoreries")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="modifiedBy")
     */
    private $updatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="journalTresoreries")
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateJ;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $recettes;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $depenses;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $solde;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vrVentes;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vrAutres;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdMobiliers;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdMarchandises;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdFournitures;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdLoyer;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdSalaires;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdImpots;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vdAutres;

    /**
     * @ORM\ManyToOne(targetEntity=JournalTresorerieSmtUtil::class, inversedBy="journalTresoreries")
     */
    private $journalTresorerieSmtUtil;




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

    public function isSubmit(): ?bool
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

    public function getDateJ(): ?\DateTimeInterface
    {
        return $this->dateJ;
    }

    public function setDateJ(?\DateTimeInterface $dateJ): self
    {
        $this->dateJ = $dateJ;

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

    public function getRecettes(): ?string
    {
        return $this->recettes;
    }

    public function setRecettes(?string $recettes): self
    {
        $this->recettes = $recettes;

        return $this;
    }

    public function getDepenses(): ?string
    {
        return $this->depenses;
    }

    public function setDepenses(?string $depenses): self
    {
        $this->depenses = $depenses;

        return $this;
    }

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(?string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getVrVentes(): ?string
    {
        return $this->vrVentes;
    }

    public function setVrVentes(?string $vrVentes): self
    {
        $this->vrVentes = $vrVentes;

        return $this;
    }

    public function getVrAutres(): ?string
    {
        return $this->vrAutres;
    }

    public function setVrAutres(?string $vrAutres): self
    {
        $this->vrAutres = $vrAutres;

        return $this;
    }

    public function getVdMobiliers(): ?string
    {
        return $this->vdMobiliers;
    }

    public function setVdMobiliers(?string $vdMobiliers): self
    {
        $this->vdMobiliers = $vdMobiliers;

        return $this;
    }

    public function getVdMarchandises(): ?string
    {
        return $this->vdMarchandises;
    }

    public function setVdMarchandises(?string $vdMarchandises): self
    {
        $this->vdMarchandises = $vdMarchandises;

        return $this;
    }

    public function getVdFournitures(): ?string
    {
        return $this->vdFournitures;
    }

    public function setVdFournitures(?string $vdFournitures): self
    {
        $this->vdFournitures = $vdFournitures;

        return $this;
    }

    public function getVdLoyer(): ?string
    {
        return $this->vdLoyer;
    }

    public function setVdLoyer(?string $vdLoyer): self
    {
        $this->vdLoyer = $vdLoyer;

        return $this;
    }

    public function getVdSalaires(): ?string
    {
        return $this->vdSalaires;
    }

    public function setVdSalaires(?string $vdSalaires): self
    {
        $this->vdSalaires = $vdSalaires;

        return $this;
    }

    public function getVdImpots(): ?string
    {
        return $this->vdImpots;
    }

    public function setVdImpots(?string $vdImpots): self
    {
        $this->vdImpots = $vdImpots;

        return $this;
    }

    public function getVdAutres(): ?string
    {
        return $this->vdAutres;
    }

    public function setVdAutres(?string $vdAutres): self
    {
        $this->vdAutres = $vdAutres;

        return $this;
    }

    public function getJournalTresorerieSmtUtil(): ?JournalTresorerieSmtUtil
    {
        return $this->journalTresorerieSmtUtil;
    }

    public function setJournalTresorerieSmtUtil(?JournalTresorerieSmtUtil $journalTresorerieSmtUtil): self
    {
        $this->journalTresorerieSmtUtil = $journalTresorerieSmtUtil;

        return $this;
    }
}
