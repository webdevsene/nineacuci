<?php

namespace App\Entity;

use App\Repository\TempNiDirigeantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiDirigeantRepository::class)
 */
class TempNiDirigeant
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
    private $ninPrenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninNom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninNumero;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninAddresse;

    /**
     * @ORM\ManyToOne(targetEntity=Qualite::class, inversedBy="tempNiDirigeants")
     */
    private $ninPosition;

    /**
     * @ORM\ManyToOne(targetEntity=TempNiNineaproposition::class, inversedBy="tempNiDirigeants")
     */
    private $ninNineaProposition;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiDirigeants")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninCni;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDateCni;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninTelephone1;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninTelephone2;

    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="tempNiDirigeants")
     */
    private $ninQvh;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninEmail;

    /**
     * @ORM\ManyToOne(targetEntity=NiCivilite::class, inversedBy="tempNiDirigeants")
     */
    private $ninCivilite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatenais;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninLieunais;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="tempNiDirigeants")
     */
    private $ninNationalite;

    /**
     * @ORM\ManyToOne(targetEntity=NiSexe::class, inversedBy="tempNiDirigeants")
     */
    private $ninSexe;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class, inversedBy="tempNiDirigeants")
     */
    private $niNinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateDeCloture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinPrenom(): ?string
    {
        return $this->ninPrenom;
    }

    public function setNinPrenom(?string $ninPrenom): self
    {
        $this->ninPrenom = $ninPrenom;

        return $this;
    }

    public function getNinNom(): ?string
    {
        return $this->ninNom;
    }

    public function setNinNom(?string $ninNom): self
    {
        $this->ninNom = $ninNom;

        return $this;
    }

    public function getNinNumero(): ?string
    {
        return $this->ninNumero;
    }

    public function setNinNumero(?string $ninNumero): self
    {
        $this->ninNumero = $ninNumero;

        return $this;
    }

    public function getNinAddresse(): ?string
    {
        return $this->ninAddresse;
    }

    public function setNinAddresse(?string $ninAddresse): self
    {
        $this->ninAddresse = $ninAddresse;

        return $this;
    }

    public function getNinPosition(): ?Qualite
    {
        return $this->ninPosition;
    }

    public function setNinPosition(?Qualite $ninPosition): self
    {
        $this->ninPosition = $ninPosition;

        return $this;
    }

    public function getNinNineaProposition(): ?TempNiNineaproposition
    {
        return $this->ninNineaProposition;
    }

    public function setNinNineaProposition(?TempNiNineaproposition $ninNineaProposition): self
    {
        $this->ninNineaProposition = $ninNineaProposition;

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

    public function getNinCni(): ?string
    {
        return $this->ninCni;
    }

    public function setNinCni(?string $ninCni): self
    {
        $this->ninCni = $ninCni;

        return $this;
    }

    public function getNinDateCni(): ?\DateTimeInterface
    {
        return $this->ninDateCni;
    }

    public function setNinDateCni(?\DateTimeInterface $ninDateCni): self
    {
        $this->ninDateCni = $ninDateCni;

        return $this;
    }

    public function getNinTelephone1(): ?string
    {
        return $this->ninTelephone1;
    }

    public function setNinTelephone1(?string $ninTelephone1): self
    {
        $this->ninTelephone1 = $ninTelephone1;

        return $this;
    }

    public function getNinTelephone2(): ?string
    {
        return $this->ninTelephone2;
    }

    public function setNinTelephone2(?string $ninTelephone2): self
    {
        $this->ninTelephone2 = $ninTelephone2;

        return $this;
    }

    public function getNinQvh(): ?QVH
    {
        return $this->ninQvh;
    }

    public function setNinQvh(?QVH $ninQvh): self
    {
        $this->ninQvh = $ninQvh;

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

    public function getNinCivilite(): ?NiCivilite
    {
        return $this->ninCivilite;
    }

    public function setNinCivilite(?NiCivilite $ninCivilite): self
    {
        $this->ninCivilite = $ninCivilite;

        return $this;
    }

    public function getNinDatenais(): ?\DateTimeInterface
    {
        return $this->ninDatenais;
    }

    public function setNinDatenais(?\DateTimeInterface $ninDatenais): self
    {
        $this->ninDatenais = $ninDatenais;

        return $this;
    }

    public function getNinLieunais(): ?string
    {
        return $this->ninLieunais;
    }

    public function setNinLieunais(?string $ninLieunais): self
    {
        $this->ninLieunais = $ninLieunais;

        return $this;
    }

    public function getNinNationalite(): ?Pays
    {
        return $this->ninNationalite;
    }

    public function setNinNationalite(?Pays $ninNationalite): self
    {
        $this->ninNationalite = $ninNationalite;

        return $this;
    }

    public function getNinSexe(): ?NiSexe
    {
        return $this->ninSexe;
    }

    public function setNinSexe(?NiSexe $ninSexe): self
    {
        $this->ninSexe = $ninSexe;

        return $this;
    }

    public function getNiNinea(): ?TempNINinea
    {
        return $this->niNinea;
    }

    public function setNiNinea(?TempNINinea $niNinea): self
    {
        $this->niNinea = $niNinea;

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
