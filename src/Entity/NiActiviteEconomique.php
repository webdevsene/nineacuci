<?php

namespace App\Entity;

use App\Repository\NiActiviteEconomiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NiActiviteEconomiqueRepository::class)
 * @Gedmo\Loggable
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
     * @Gedmo\Versioned 
     */
    private $ninAnneeCa;





    /**
     * @ORM\Column(type="float", nullable=true)
     * @Gedmo\Versioned 
     */
    private $ninCapital;


    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned 
     */
    private $ninEffect1;


    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned 
     */
    private $ninEffectifFem;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Gedmo\Versioned 
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
     * @Gedmo\Versioned 
     */
    private $ninEffectif;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Gedmo\Versioned 
     */
    private $ninAffaire;

    /**
     * @ORM\ManyToOne(targetEntity=NiNineaproposition::class, inversedBy="niActiviteEconomiques")
     */
    private $niNineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="ninActivitesEconomiques")
     * @Gedmo\Versioned 
     */
    private $nINinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Gedmo\Versioned 
     */
    private $DeteDeCloture;

    /**
     * @ORM\ManyToOne(targetEntity=NiSourcefinancement::class, inversedBy="niActiviteEconomiques")
     */
    private $ninOcc;

    /**
     * @ORM\ManyToOne(targetEntity=NiModaliteexploitation::class, inversedBy="niActiviteEconomiques")
     */
    private $ninMode;

    /**
     * @ORM\ManyToOne(targetEntity=NiNatureLocaliteExploitation::class, inversedBy="niActiviteEconomiques")
     */
    private $ninNature;


    
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
