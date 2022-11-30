<?php

namespace App\Entity;

use App\Repository\HistoryNiActiviteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryNiActiviteRepository::class)
 */
class HistoryNiActivite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMA::class, inversedBy="niNineaproposition")
     */
    private $refNaema;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNiNineaproposition::class, inversedBy="historyNiActivites")
     * @ORM\JoinColumn(name="history_ni_nineaproposition_id", referencedColumnName="id")
     */
    private $niNineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNINinea::class, inversedBy="historyNiActivites")
     * @ORM\JoinColumn(name="history_ni_ninea_id", referencedColumnName="id")
     */
    private $niNinea;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninAutact;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historyNiActivites")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statActivprincipale;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDeCloture;

    public function __construct()
    {
        $this->id = uniqid();
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();

    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getRefNaema(): ?NAEMA
    {
        return $this->refNaema;
    }

    public function setRefNaema(?NAEMA $refNaema): self
    {
        $this->refNaema = $refNaema;

        return $this;
    }

    public function getNiNineaproposition(): ?HistoryNiNineaproposition
    {
        return $this->niNineaproposition;
    }

    public function setNiNineaproposition(?HistoryNiNineaproposition $niNineaproposition): self
    {
        $this->niNineaproposition = $niNineaproposition;

        return $this;
    }

    public function getNiNinea(): ?HistoryNINinea
    {
        return $this->niNinea;
    }

    public function setNiNinea(?HistoryNINinea $niNinea): self
    {
        $this->niNinea = $niNinea;

        return $this;
    }

    public function getNinAutact(): ?string
    {
        return $this->ninAutact;
    }

    public function setNinAutact(?string $ninAutact): self
    {
        $this->ninAutact = $ninAutact;

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

    public function isStatActivprincipale(): ?bool
    {
        return $this->statActivprincipale;
    }

    public function setStatActivprincipale(?bool $statActivprincipale): self
    {
        $this->statActivprincipale = $statActivprincipale;

        return $this;
    }

    public function getDateDeCloture(): ?\DateTimeInterface
    {
        return $this->DateDeCloture;
    }

    public function setDateDeCloture(?\DateTimeInterface $DateDeCloture): self
    {
        $this->DateDeCloture = $DateDeCloture;

        return $this;
    }
}
