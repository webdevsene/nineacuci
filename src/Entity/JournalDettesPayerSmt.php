<?php

namespace App\Entity;

use App\Repository\JournalDettesPayerSmtRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=JournalDettesPayerSmtRepository::class)
 * @ORM\Table(name="`cuci_journal_des_dettes_apayer_smt`")
 * @Gedmo\Loggable
 */
class JournalDettesPayerSmt
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="journalDettesPayerSmts")
     */
    private $repertoire;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="journalDettesPayerSmts")
     * @ORM\JoinColumn(name="createdby")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="journalDettesPayerSmtsUpdatedBy")
     * @ORM\JoinColumn(name="updatedby")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $status;

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
    private $numFacture;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Gedmo\Versioned
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePaiement;

    /**
     * @ORM\ManyToOne(targetEntity=JournalDettesPayerSmtUtil::class, inversedBy="journalDettesPayerSmts")
     * @ORM\JoinColumn(name="journalDettesPayerSmtUtilID")
     */
    private $journalDettesPayerSmtUtil;


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

    public function getRepertoire(): ?Repertoire
    {
        return $this->repertoire;
    }

    public function setRepertoire(?Repertoire $repertoire): self
    {
        $this->repertoire = $repertoire;

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

    public function getNumFacture(): ?string
    {
        return $this->numFacture;
    }

    public function setNumFacture(?string $numFacture): self
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

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

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getJournalDettesPayerSmtUtil(): ?JournalDettesPayerSmtUtil
    {
        return $this->journalDettesPayerSmtUtil;
    }

    public function setJournalDettesPayerSmtUtil(?JournalDettesPayerSmtUtil $journalDettesPayerSmtUtil): self
    {
        $this->journalDettesPayerSmtUtil = $journalDettesPayerSmtUtil;

        return $this;
    }
}
