<?php

namespace App\Entity;

use App\Repository\CAVRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CAVRepository::class)
 */
class CAV
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $codeCav;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $libelle;

 

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

  
    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="cAVs")
     */
    private $cavDEPID;

    /**
     * @ORM\OneToMany(targetEntity=CACR::class, mappedBy="cacrCAVID")
     */
    private $cACRs;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $cavActiveF;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cavCDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cavCUSER;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $cavCDMIG;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cavMDATE;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $cavMUSER;

    public function __construct()
    {
        $this->cACRs = new ArrayCollection();
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

    public function getCodeCav(): ?string
    {
        return $this->codeCav;
    }

    public function setCodeCav(?string $codeCav): self
    {
        $this->codeCav = $codeCav;

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

  

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }



    public function getCavDEPID(): ?Departement
    {
        return $this->cavDEPID;
    }

    public function setCavDEPID(?Departement $cavDEPID): self
    {
        $this->cavDEPID = $cavDEPID;

        return $this;
    }

    /**
     * @return Collection|CACR[]
     */
    public function getCACRs(): Collection
    {
        return $this->cACRs;
    }

    public function addCACR(CACR $cACR): self
    {
        if (!$this->cACRs->contains($cACR)) {
            $this->cACRs[] = $cACR;
            $cACR->setCacrCAVID($this);
        }

        return $this;
    }

    public function removeCACR(CACR $cACR): self
    {
        if ($this->cACRs->removeElement($cACR)) {
            // set the owning side to null (unless already changed)
            if ($cACR->getCacrCAVID() === $this) {
                $cACR->setCacrCAVID(null);
            }
        }

        return $this;
    }

    public function getCavActiveF(): ?string
    {
        return $this->cavActiveF;
    }

    public function setCavActiveF(?string $cavActiveF): self
    {
        $this->cavActiveF = $cavActiveF;

        return $this;
    }

    public function getCavCDATE(): ?string
    {
        return $this->cavCDATE;
    }

    public function setCavCDATE(?string $cavCDATE): self
    {
        $this->cavCDATE = $cavCDATE;

        return $this;
    }

    public function getCavCUSER(): ?string
    {
        return $this->cavCUSER;
    }

    public function setCavCUSER(?string $cavCUSER): self
    {
        $this->cavCUSER = $cavCUSER;

        return $this;
    }

    public function getCavCDMIG(): ?string
    {
        return $this->cavCDMIG;
    }

    public function setCavCDMIG(?string $cavCDMIG): self
    {
        $this->cavCDMIG = $cavCDMIG;

        return $this;
    }

    public function getCavMDATE(): ?string
    {
        return $this->cavMDATE;
    }

    public function setCavMDATE(?string $cavMDATE): self
    {
        $this->cavMDATE = $cavMDATE;

        return $this;
    }

    public function getCavMUSER(): ?string
    {
        return $this->cavMUSER;
    }

    public function setCavMUSER(?string $cavMUSER): self
    {
        $this->cavMUSER = $cavMUSER;

        return $this;
    }
}
