<?php

namespace App\Entity;

use App\Repository\CitiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CitiRepository::class)
 * @ORM\Table(name="ref_citi")
 */
class Citi
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
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="cITI")
     */
    private $activites;

    

    
    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="citi")
     */
    private $repertoires;

    /**
     * @ORM\OneToMany(targetEntity=NiActivite::class, mappedBy="refCiti")
     */
    private $niActivites;

    /**
     * @ORM\ManyToOne(targetEntity=RefCategoryCitiNew::class, inversedBy="citi")
     */
    private $refCategoryCitiNew;

    /**
     * @ORM\OneToMany(targetEntity=TempNiActivite::class, mappedBy="refCiti")
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

    public function getId(): ?string
    {
        return $this->id;
    }


     public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }



    public function getLibelle(): ?string
    {
        return $this->libelle;
    }


    public function getCiti(): ?string
    {
        return  $this->id."-".$this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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
            $repertoire->setCiti($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getCiti() === $this) {
                $repertoire->setCiti(null);
            }
        }

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
            $activite->setCITI($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getCITI() === $this) {
                $activite->setCITI(null);
            }
        }

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
            $niActivite->setRefCiti($this);
        }

        return $this;
    }

    public function removeNiActivite(NiActivite $niActivite): self
    {
        if ($this->niActivites->removeElement($niActivite)) {
            // set the owning side to null (unless already changed)
            if ($niActivite->getRefCiti() === $this) {
                $niActivite->setRefCiti(null);
            }
        }

        return $this;
    }

    public function getRefCategoryCitiNew(): ?RefCategoryCitiNew
    {
        return $this->refCategoryCitiNew;
    }

    public function setRefCategoryCitiNew(?RefCategoryCitiNew $refCategoryCitiNew): self
    {
        $this->refCategoryCitiNew = $refCategoryCitiNew;

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
            $tempNiActivite->setRefCiti($this);
        }

        return $this;
    }

    public function removeTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if ($this->tempNiActivites->removeElement($tempNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActivite->getRefCiti() === $this) {
                $tempNiActivite->setRefCiti(null);
            }
        }

        return $this;
    }
}
