<?php

namespace App\Entity;

use App\Repository\SYSCOARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SYSCOARepository::class)
 * @ORM\Table(name="ref_syscoa")
 */
class SYSCOA
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="sYSCOA")
     */
    private $activite;


    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="syscoa")
     */
    private $repertoires;

   

    /**
     * @ORM\ManyToOne(targetEntity=CategorySyscoa::class, inversedBy="syscoa")
     */
    private $categorySyscoa;

   

    



    /**
     * @ORM\OneToMany(targetEntity=NiActivite::class, mappedBy="refSyscoa")
     */
    private $niActivites;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->activite = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
        $this->niActivites = new ArrayCollection();
        
    }


     /**
     * toString
     * @return string
     */
    public  function __toString()
    {
        return $this->libelle;
    }


     public function getCodeLibelle(): ?string
    {
        return $this->id."-".$this->libelle;
    }


       /**
     * @return Collection|Repertoires[]
     */
    public function getRepertoire(): Collection
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setSYSCOA($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getSYSCOA() === $this) {
                $repertoire->setSYSCOA(null);
            }
        }

        return $this;
    }




     public function getSyscoa(): ?string
    {
        return  $this->id."-".$this->libelle;
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

    /**
     * @return Collection|Activities[]
     */
    public function getActivite(): Collection
    {
        return $this->activite;
    }

    public function addActivite(Activities $activite): self
    {
        if (!$this->activite->contains($activite)) {
            $this->activite[] = $activite;
            $activite->setSYSCOA($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activite->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getSYSCOA() === $this) {
                $activite->setSYSCOA(null);
            }
        }

        return $this;
    }

    public function getCodeSyscoa(): ?string
    {
        return $this->codeSyscoa;
    }

    public function setCodeSyscoa(?string $codeSyscoa): self
    {
        $this->codeSyscoa = $codeSyscoa;

        return $this;
    }

    public function getCategorySyscoa(): ?CategorySyscoa
    {
        return $this->categorySyscoa;
    }

    public function setCategorySyscoa(?CategorySyscoa $categorySyscoa): self
    {
        $this->categorySyscoa = $categorySyscoa;

        return $this;
    }

   



  




    /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoires(): Collection
    {
        return $this->repertoires;
    }

    /**
     * @return Collection<int, NiActivite>
     */
    public function getNiActivites(): Collection
    {
        return $this->niActivites;
    }

    public function addNiActivite(NiActivite $niActivite): self
    {
        if (!$this->niActivites->contains($niActivite)) {
            $this->niActivites[] = $niActivite;
            $niActivite->setRefSyscoa($this);
        }

        return $this;
    }

    public function removeNiActivite(NiActivite $niActivite): self
    {
        if ($this->niActivites->removeElement($niActivite)) {
            // set the owning side to null (unless already changed)
            if ($niActivite->getRefSyscoa() === $this) {
                $niActivite->setRefSyscoa(null);
            }
        }

        return $this;
    }

   

   
}
