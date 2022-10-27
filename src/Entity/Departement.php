<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=DepartementRepository::class)
 * @ORM\Table(name="ref_departement")
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codeDep;

   


    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    

    /**
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="departements")
     */
    private $depRegCD;

    /**
     * @ORM\OneToMany(targetEntity=CAV::class, mappedBy="cavDEPID")
     */
    private $cAVs;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $depActiveF;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $depCDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $depCUSER;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $depCDMIG;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $depMDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $depMUSER;

    public function __construct()
    {
        $this->cAVs = new ArrayCollection();
    }

    /**
     * toString
     * @return string 
     */
    public  function __toString()
    {
        return $this->libelle;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCodeDep(): ?string
    {
        return $this->codeDep;
    }

    public function setCodeDep(?string $codeDep): self
    {
        $this->codeDep = $codeDep;

        return $this;
    }



   
  

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDepRegCD(): ?Region
    {
        return $this->depRegCD;
    }

    public function setDepRegCD(?Region $depRegCD): self
    {
        $this->depRegCD = $depRegCD;

        return $this;
    }

    /**
     * @return Collection|CAV[]
     */
    public function getCAVs(): Collection
    {
        return $this->cAVs;
    }

    public function addCAV(CAV $cAV): self
    {
        if (!$this->cAVs->contains($cAV)) {
            $this->cAVs[] = $cAV;
            $cAV->setCavDEPID($this);
        }

        return $this;
    }

    public function removeCAV(CAV $cAV): self
    {
        if ($this->cAVs->removeElement($cAV)) {
            // set the owning side to null (unless already changed)
            if ($cAV->getCavDEPID() === $this) {
                $cAV->setCavDEPID(null);
            }
        }

        return $this;
    }

    public function getDepActiveF(): ?string
    {
        return $this->depActiveF;
    }

    public function setDepActiveF(?string $depActiveF): self
    {
        $this->depActiveF = $depActiveF;

        return $this;
    }

    public function getDepCDATE(): ?string
    {
        return $this->depCDATE;
    }

    public function setDepCDATE(?string $depCDATE): self
    {
        $this->depCDATE = $depCDATE;

        return $this;
    }

    public function getDepCUSER(): ?string
    {
        return $this->depCUSER;
    }

    public function setDepCUSER(?string $depCUSER): self
    {
        $this->depCUSER = $depCUSER;

        return $this;
    }

    public function getDepCDMIG(): ?string
    {
        return $this->depCDMIG;
    }

    public function setDepCDMIG(?string $depCDMIG): self
    {
        $this->depCDMIG = $depCDMIG;

        return $this;
    }

    public function getDepMDATE(): ?string
    {
        return $this->depMDATE;
    }

    public function setDepMDATE(?string $depMDATE): self
    {
        $this->depMDATE = $depMDATE;

        return $this;
    }

    public function getDepMUSER(): ?string
    {
        return $this->depMUSER;
    }

    public function setDepMUSER(?string $depMUSER): self
    {
        $this->depMUSER = $depMUSER;

        return $this;
    }
}
