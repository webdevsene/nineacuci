<?php

namespace App\Entity;

use App\Repository\NAEMARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NAEMARepository::class)
 * @ORM\Table(name="ref_naema")
 */
class NAEMA
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
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="nAEMA")
     */
    private $activites;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="naema")
     */
    private $repertoires;

    /**
     * @ORM\OneToMany(targetEntity=NiActivite::class, mappedBy="refNaema")
     */
    private $niActivites;

    /**
     * @ORM\ManyToOne(targetEntity=RefNaemaNew::class, inversedBy="naema")
     */
    private $refNaemaNew;

    /**
     * @ORM\OneToMany(targetEntity=RefProduits::class, mappedBy="naema")
     */
    private $refProduits;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActivite::class, mappedBy="refNaema")
     */
    private $historyNiActivites;

    /**
     * @ORM\OneToMany(targetEntity=TempNiActivite::class, mappedBy="refNaema")
     */
    private $tempNiActivites;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
        $this->niActivites = new ArrayCollection();
        $this->refProduits = new ArrayCollection();
        $this->historyNiActivites = new ArrayCollection();
        $this->tempNiActivites = new ArrayCollection();
    }


    public function getCodeLibelle(): ?string
    {
        return $this->id."-".$this->libelle;
    }

    public function __toString()
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
            $repertoire->setNaema($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getNaema() === $this) {
                $repertoire->setNaema(null);
            }
        }

        return $this;
    }


     public function getNaema(): ?string
    {
        return  $this->id."-".$this->libelle;
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
            $activite->setNAEMA($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getNAEMA() === $this) {
                $activite->setNAEMA(null);
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
            $niActivite->setRefNaema($this);
        }

        return $this;
    }

    public function removeNiActivite(NiActivite $niActivite): self
    {
        if ($this->niActivites->removeElement($niActivite)) {
            // set the owning side to null (unless already changed)
            if ($niActivite->getRefNaema() === $this) {
                $niActivite->setRefNaema(null);
            }
        }

        return $this;
    }

    public function getRefNaemaNew(): ?RefNaemaNew
    {
        return $this->refNaemaNew;
    }

    public function setRefNaemaNew(?RefNaemaNew $refNaemaNew): self
    {
        $this->refNaemaNew = $refNaemaNew;

        return $this;
    }

    /**
     * @return Collection<int, RefProduits>
     */
    public function getRefProduits(): Collection
    {
        return $this->refProduits;
    }

    public function addRefProduit(RefProduits $refProduit): self
    {
        if (!$this->refProduits->contains($refProduit)) {
            $this->refProduits[] = $refProduit;
            $refProduit->setNaema($this);
        }

        return $this;
    }

    public function removeRefProduit(RefProduits $refProduit): self
    {
        if ($this->refProduits->removeElement($refProduit)) {
            // set the owning side to null (unless already changed)
            if ($refProduit->getNaema() === $this) {
                $refProduit->setNaema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiActivite>
     */
    public function getHistoryNiActivites(): Collection
    {
        return $this->historyNiActivites;
    }

    public function addHistoryNiActivites(HistoryNiActivite $historyNiActivites): self
    {
        if (!$this->historyNiActivites->contains($historyNiActivites)) {
            $this->historyNiActivites[] = $historyNiActivites;
            $historyNiActivites->setRefNaema($this);
        }

        return $this;
    }

    public function removeHistoryNiActivites(HistoryNiActivite $historyNiActivites): self
    {
        if ($this->historyNiActivites->removeElement($historyNiActivites)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActivites->getRefNaema() === $this) {
                $historyNiActivites->setRefNaema(null);
            }
        }

        return $this;
    }

    public function addHistoryNiActivite(HistoryNiActivite $historyNiActivite): self
    {
        if (!$this->historyNiActivites->contains($historyNiActivite)) {
            $this->historyNiActivites[] = $historyNiActivite;
            $historyNiActivite->setRefNaema($this);
        }

        return $this;
    }

    public function removeHistoryNiActivite(HistoryNiActivite $historyNiActivite): self
    {
        if ($this->historyNiActivites->removeElement($historyNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActivite->getRefNaema() === $this) {
                $historyNiActivite->setRefNaema(null);
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
            $tempNiActivite->setRefNaema($this);
        }

        return $this;
    }

    public function removeTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if ($this->tempNiActivites->removeElement($tempNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActivite->getRefNaema() === $this) {
                $tempNiActivite->setRefNaema(null);
            }
        }

        return $this;
    }
}
