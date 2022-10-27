<?php

namespace App\Entity;

use App\Repository\NiActiviteEconomiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiActiviteEconomiqueRepository::class)
 */
class NiActiviteEconomique
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninMode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninNature;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ninCapital;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ninOcc;

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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="niActiviteEconomiques")
     */
    private $createBy;

   

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
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
     * @ORM\ManyToOne(targetEntity=NiNineaproposition::class, inversedBy="niActiviteEconomiques")
     */
    private $niNineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="ninActivitesEconomiques")
     */
    private $nINinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DeteDeCloture;


    
    public function __construct()
    {
        
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
       
        
    }

    public function __toString()
    {
        return $this->id;
    }


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

    public function getNinMode(): ?string
    {
        return $this->ninMode;
    }

    public function setNinMode(?string $ninMode): self
    {
        $this->ninMode = $ninMode;

        return $this;
    }

    public function getNinNature(): ?string
    {
        return $this->ninNature;
    }

    public function setNinNature(?string $ninNature): self
    {
        $this->ninNature = $ninNature;

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

    public function getNinOcc(): ?string
    {
        return $this->ninOcc;
    }

    public function setNinOcc(string $ninOcc): self
    {
        $this->ninOcc = $ninOcc;

        return $this;
    }

    public function getNinEffect1(): ?int
    {
        return $this->ninEffect1;
    }

    public function setNinEffect1(?int $nin_Effect1): self
    {
        $this->ninEffect1 = $nin_Effect1;

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

    public function getNinEffectifFem(): ?int
    {
        return $this->ninEffectifFem;
    }

    public function setNinEffectifFem(?int $ninEffectifFem): self
    {
        $this->ninEffectifFem = $ninEffectifFem;

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

    public function getNiNineaproposition(): ?NiNineaproposition
    {
        return $this->niNineaproposition;
    }

    public function setNiNineaproposition(?NiNineaproposition $niNineaproposition): self
    {
        $this->niNineaproposition = $niNineaproposition;

        return $this;
    }

    public function getNINinea(): ?NINinea
    {
        return $this->nINinea;
    }

    public function setNINinea(?NINinea $nINinea): self
    {
        $this->nINinea = $nINinea;

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



    
}
