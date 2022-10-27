<?php

namespace App\Entity;

use App\Repository\HistoryNiCoordonneesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryNiCoordonneesRepository::class)
 * @ORM\Table(name="`history_ni_adresse`")
 */
class HistoryNiCoordonnees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=NiTypevoie::class, inversedBy="historyNiCoordonnees")
     */
    private $ninTypeVoie;

    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="historyNiCoordonnees")
     */
    private $qvh;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNINinea::class, inversedBy="historyNiCoordonnees")
     * @ORM\JoinColumn(name="history_ni_ninea_id", referencedColumnName="id")
     */
    private $ninNinea;

    /**
     * @ORM\Column(type="string", length=255, name="nin_NumVoie")
     */
    private $ninnumVoie;

    /**
     * @ORM\Column(type="string",  length=100, nullable=true, name="nin_Voie")
     */
    private $ninVoie;

    /**
     * @ORM\Column(type="text", length=200,  nullable=true, name="nin_Adresse1")
     */
    private $ninadresse1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="nin_AdresseDomicile")
     */
    private $ninadresse2;

    /**
     * @ORM\Column(type="string", length=20, nullable=true, name="nin_Telephon2" )
     */
    private $nintelephon2;

    /**
     * @ORM\Column(type="string", length=10, name="nin_Telephon1")
     */
    private $ninTelephon1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="string", length=50, nullable=true, name="nin_BP")
     */
    private $ninBP;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninUrl;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateFin;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNiNineaproposition::class, inversedBy="niCoordonnees")
     */
    private $historyNiNineaproposition;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinTypeVoie(): ?NiTypevoie
    {
        return $this->ninTypeVoie;
    }

    public function setNinTypeVoie(?NiTypevoie $ninTypeVoie): self
    {
        $this->ninTypeVoie = $ninTypeVoie;

        return $this;
    }

    public function getQvh(): ?QVH
    {
        return $this->qvh;
    }

    public function setQvh(?QVH $qvh): self
    {
        $this->qvh = $qvh;

        return $this;
    }

    public function getNinNinea(): ?HistoryNINinea
    {
        return $this->ninNinea;
    }

    public function setNinNinea(?HistoryNINinea $ninNinea): self
    {
        $this->ninNinea = $ninNinea;

        return $this;
    }

    public function getNinnumVoie(): ?string
    {
        return $this->ninnumVoie;
    }

    public function setNinnumVoie(?string $ninnumVoie): self
    {
        $this->ninnumVoie = $ninnumVoie;

        return $this;
    }

    public function getNinVoie(): ?string
    {
        return $this->ninVoie;
    }

    public function setNinVoie(?string $ninVoie): self
    {
        $this->ninVoie = $ninVoie;

        return $this;
    }

    public function getNinadresse1(): ?string
    {
        return $this->ninadresse1;
    }

    public function setNinadresse1(?string $ninadresse1): self
    {
        $this->ninadresse1 = $ninadresse1;

        return $this;
    }

    public function getNinEmail(): ?string
    {
        return $this->ninEmail;
    }

    public function setNinEmail(?string $ninEmail): self
    {
        $this->ninEmail = $ninEmail;

        return $this;
    }

    public function getNinadresse2(): ?string
    {
        return $this->ninadresse2;
    }

    public function setNinadresse2(?string $ninadresse2): self
    {
        $this->ninadresse2 = $ninadresse2;

        return $this;
    }

    public function getNintelephon2(): ?string
    {
        return $this->nintelephon2;
    }

    public function setNintelephon2(?string $nintelephon2): self
    {
        $this->nintelephon2 = $nintelephon2;

        return $this;
    }

    public function getNinTelephon1(): ?string
    {
        return $this->ninTelephon1;
    }

    public function setNinTelephon1(?string $ninTelephon1): self
    {
        $this->ninTelephon1 = $ninTelephon1;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getNinBP(): ?string
    {
        return $this->ninBP;
    }

    public function setNinBP(?string $ninBP): self
    {
        $this->ninBP = $ninBP;

        return $this;
    }

    public function getNinUrl(): ?string
    {
        return $this->ninUrl;
    }

    public function setNinUrl(?string $ninUrl): self
    {
        $this->ninUrl = $ninUrl;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(?\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getHistoryNiNineaproposition(): ?HistoryNiNineaproposition
    {
        return $this->historyNiNineaproposition;
    }

    public function setHistoryNiNineaproposition(?HistoryNiNineaproposition $historyNiNineaproposition): self
    {
        $this->historyNiNineaproposition = $historyNiNineaproposition;

        return $this;
    }
}
