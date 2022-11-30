<?php

namespace App\Entity;

use App\Repository\HistoryNiActiviteEconomiqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryNiActiviteEconomiqueRepository::class)
 */
class HistoryNiActiviteEconomique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historyNiActiviteEconomiques")
     */
    private $createBy;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNiNineaproposition::class, inversedBy="historyNiActiviteEconomiques")
     * @ORM\JoinColumn(name="history_ni_nineaproposition_id", referencedColumnName="id")
     */
    private $niNineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNINinea::class, inversedBy="historyNiActiviteEconomiques")
     * @ORM\JoinColumn(name="history_ni_ninea_id", referencedColumnName="id")
     */
    private $niNinea;

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
     * @ORM\Column(type="date", nullable=true)
     */
    private $DeteDeCloture;

    /**
     * @ORM\ManyToOne(targetEntity=NiSourcefinancement::class, inversedBy="historyNiActiviteEconomiques")
     */
    private $ninOcc;

    /**
     * @ORM\ManyToOne(targetEntity=NiModaliteexploitation::class, inversedBy="historyNiActiviteEconomiques")
     */
    private $ninMode;

    /**
     * @ORM\ManyToOne(targetEntity=NiNatureLocaliteExploitation::class, inversedBy="historyNiActiviteEconomiques")
     */
    private $ninNature;

    public function getId(): ?int
    {
        return $this->id;
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
