<?php

namespace App\Entity;

use App\Repository\TempNiActiviteEconomiqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiActiviteEconomiqueRepository::class)
 */
class TempNiActiviteEconomique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $ninAnneeCa;

   

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ninCapital;

   

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ninEffect1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ninEffectifFem;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ninEffectifFemSAIS;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiActiviteEconomiques")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiActiviteEconomiques")
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ninEffectif;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ninAffaire;

    /**
     * @ORM\ManyToOne(targetEntity=TempNiNineaproposition::class, inversedBy="tempNiActiviteEconomiques")
     */
    private $niNineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class, inversedBy="tempNiActiviteEconomiques")
     */
    private $niNinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DeteDeCloture;

    /**
     * @ORM\ManyToOne(targetEntity=NiSourcefinancement::class, inversedBy="tempNiActiviteEconomiques")
     */
    private $ninOcc;

    /**
     * @ORM\ManyToOne(targetEntity=NiModaliteexploitation::class, inversedBy="tempNiActiviteEconomiques")
     */
    private $ninMode;

    /**
     * @ORM\ManyToOne(targetEntity=NiNatureLocaliteExploitation::class, inversedBy="tempNiActiviteEconomiques")
     */
    private $ninNature;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinAnneeCa(): ?string
    {
        return $this->ninAnneeCa;
    }

    public function setNinAnneeCa(?string $ninAnneeCa): self
    {
        $this->ninAnneeCa = $ninAnneeCa;

        return $this;
    }

  

    

    public function getNinCapital(): ?float
    {
        return $this->ninCapital;
    }

    public function setNinCapital(?float $ninCapital): self
    {
        $this->ninCapital = $ninCapital;

        return $this;
    }

    

    public function getNinEffect1(): ?int
    {
        return $this->ninEffect1;
    }

    public function setNinEffect1(?int $ninEffect1): self
    {
        $this->ninEffect1 = $ninEffect1;

        return $this;
    }

    public function getNinEffectifFem(): ?int
    {
        return $this->ninEffectifFem;
    }

    public function setNinEffectifFem(?int $ninEffectifFem): self
    {
        $this->ninEffectifFem = $ninEffectifFem;

        return $this;
    }

    public function getNinEffectifFemSAIS(): ?int
    {
        return $this->ninEffectifFemSAIS;
    }

    public function setNinEffectifFemSAIS(?int $ninEffectifFemSAIS): self
    {
        $this->ninEffectifFemSAIS = $ninEffectifFemSAIS;

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

    public function getNinEffectif(): ?int
    {
        return $this->ninEffectif;
    }

    public function setNinEffectif(?int $ninEffectif): self
    {
        $this->ninEffectif = $ninEffectif;

        return $this;
    }

    public function getNinAffaire(): ?float
    {
        return $this->ninAffaire;
    }

    public function setNinAffaire(?float $ninAffaire): self
    {
        $this->ninAffaire = $ninAffaire;

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

    public function getNiNinea(): ?TempNINinea
    {
        return $this->niNinea;
    }

    public function setNiNinea(?TempNINinea $niNinea): self
    {
        $this->niNinea = $niNinea;

        return $this;
    }

    public function getDeteDeCloture(): ?\DateTimeInterface
    {
        return $this->DeteDeCloture;
    }

    public function setDeteDeCloture(?\DateTimeInterface $DeteDeCloture): self
    {
        $this->DeteDeCloture = $DeteDeCloture;

        return $this;
    }

    public function getNinOcc(): ?NiSourcefinancement
    {
        return $this->ninOcc;
    }

    public function setNinOcc(?NiSourcefinancement $ninOcc): self
    {
        $this->ninOcc = $ninOcc;

        return $this;
    }

    public function getNinMode(): ?NiModaliteexploitation
    {
        return $this->ninMode;
    }

    public function setNinMode(?NiModaliteexploitation $ninMode): self
    {
        $this->ninMode = $ninMode;

        return $this;
    }

    public function getNinNature(): ?NiNatureLocaliteExploitation
    {
        return $this->ninNature;
    }

    public function setNinNature(?NiNatureLocaliteExploitation $ninNature): self
    {
        $this->ninNature = $ninNature;

        return $this;
    }
}
