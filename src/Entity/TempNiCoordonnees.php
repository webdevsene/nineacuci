<?php

namespace App\Entity;

use App\Repository\TempNiCoordonneesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiCoordonneesRepository::class)
 */
class TempNiCoordonnees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninnumVoie;

    /**
     * @ORM\ManyToOne(targetEntity=NiTypevoie::class, inversedBy="tempNiCoordonnees")
     */
    private $ninTypeVoie;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninVoie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ninadresse1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninadresse2;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $nintelephon2;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninTelephon1;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiCoordonnees")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiCoordonnees")
     */
    private $updatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="tempNiCoordonnees")
     */
    private $qvh;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class, inversedBy="tempNiCoordonnees")
     */
    private $ninNinea;

    /**
     * @ORM\ManyToOne(targetEntity=TempNiNineaproposition::class, inversedBy="tempNiCoordonnees")
     */
    private $niNineaproposition;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninBP;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninUrl;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateFin;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNinTypeVoie(): ?NiTypevoie
    {
        return $this->ninTypeVoie;
    }

    public function setNinTypeVoie(?NiTypevoie $ninTypeVoie): self
    {
        $this->ninTypeVoie = $ninTypeVoie;

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

    public function getQvh(): ?QVH
    {
        return $this->qvh;
    }

    public function setQvh(?QVH $qvh): self
    {
        $this->qvh = $qvh;

        return $this;
    }

    public function getNinNinea(): ?TempNINinea
    {
        return $this->ninNinea;
    }

    public function setNinNinea(?TempNINinea $ninNinea): self
    {
        $this->ninNinea = $ninNinea;

        return $this;
    }

    public function getNiNineaproposition(): ?TempNiNineaproposition
    {
        return $this->niNineaproposition;
    }

    public function setNiNineaproposition(?TempNiNineaproposition $niNineaproposition): self
    {
        $this->niNineaproposition = $niNineaproposition;

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
}
