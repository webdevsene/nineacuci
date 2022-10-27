<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RegionRepository::class)
 * @ORM\Table(name="ref_region")
 */
class Region
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;






    /**
     * @ORM\OneToMany(targetEntity=Departement::class, mappedBy="depRegCD")
     */
    private $departements;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $regActiveF;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $regCDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regCUSER;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regCDMIG;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regContactDetails;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $regMDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regMUSER;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }


    public function __toString()
    {

            return $this->id;
        
    }


    /**
     * @return Collection|Departement[]
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
            $departement->setDepRegCD($this);
        }

        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        if ($this->departements->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getDepRegCD() === $this) {
                $departement->setDepRegCD(null);
            }
        }

        return $this;
    }

    public function getRegActiveF(): ?string
    {
        return $this->regActiveF;
    }

    public function setRegActiveF(?string $regActiveF): self
    {
        $this->regActiveF = $regActiveF;

        return $this;
    }

    public function getRegCDATE(): ?string
    {
        return $this->regCDATE;
    }

    public function setRegCDATE(?string $regCDATE): self
    {
        $this->regCDATE = $regCDATE;

        return $this;
    }

    public function getRegCUSER(): ?string
    {
        return $this->regCUSER;
    }

    public function setRegCUSER(?string $regCUSER): self
    {
        $this->regCUSER = $regCUSER;

        return $this;
    }

    public function getRegCDMIG(): ?string
    {
        return $this->regCDMIG;
    }

    public function setRegCDMIG(?string $regCDMIG): self
    {
        $this->regCDMIG = $regCDMIG;

        return $this;
    }

    public function getRegContactDetails(): ?string
    {
        return $this->regContactDetails;
    }

    public function setRegContactDetails(?string $regContactDetails): self
    {
        $this->regContactDetails = $regContactDetails;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getRegMDATE(): ?string
    {
        return $this->regMDATE;
    }

    public function setRegMDATE(?string $regMDATE): self
    {
        $this->regMDATE = $regMDATE;

        return $this;
    }

    public function getRegMUSER(): ?string
    {
        return $this->regMUSER;
    }

    public function setRegMUSER(?string $regMUSER): self
    {
        $this->regMUSER = $regMUSER;

        return $this;
    }
}
