<?php

namespace App\Entity;

use App\Repository\NAEMASRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NAEMASRepository::class)
 * @ORM\Table(name="ref_naemas")
 */
class NAEMAS
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $id;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="nAEMAS")
     */
    private $activites;

   

    /**
     * @ORM\ManyToOne(targetEntity=CategoryNaemas::class, inversedBy="naemas")
     */
    private $categoryNaemas;



    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="naemas")
     */
    private $repertoires;

   

    /**
     * @ORM\OneToMany(targetEntity=NiActivite::class, mappedBy="refNaemas")
     */
    private $niActivites;

    /**
     * @ORM\OneToMany(targetEntity=TempNiActivite::class, mappedBy="refNaemas")
     */
    private $tempNiActivites;


    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
        $this->niActivites = new ArrayCollection();
        $this->tempNiActivites = new ArrayCollection();
    }

    public function __toString()
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
            $repertoire->setNaemas($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getNaemas() === $this) {
                $repertoire->setNaemas(null);
            }
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

     public function getNaemas(): ?string
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
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activities $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setNAEMAS($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getNAEMAS() === $this) {
                $activite->setNAEMAS(null);
            }
        }

        return $this;
    }

   
    public function getCategoryNaemas(): ?CategoryNaemas
    {
        return $this->categoryNaemas;
    }

    public function setCategoryNaemas(?CategoryNaemas $categoryNaemas): self
    {
        $this->categoryNaemas = $categoryNaemas;

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
            $niActivite->setRefNaemas($this);
        }

        return $this;
    }

    public function removeNiActivite(NiActivite $niActivite): self
    {
        if ($this->niActivites->removeElement($niActivite)) {
            // set the owning side to null (unless already changed)
            if ($niActivite->getRefNaemas() === $this) {
                $niActivite->setRefNaemas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiActivite>
     */
    public function getTempNiActivites(): Collection
    {
        return $this->tempNiActivites;
    }

    public function addTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if (!$this->tempNiActivites->contains($tempNiActivite)) {
            $this->tempNiActivites[] = $tempNiActivite;
            $tempNiActivite->setRefNaemas($this);
        }

        return $this;
    }

    public function removeTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if ($this->tempNiActivites->removeElement($tempNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActivite->getRefNaemas() === $this) {
                $tempNiActivite->setRefNaemas(null);
            }
        }

        return $this;
    }

   
}
