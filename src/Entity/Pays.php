<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 * @ORM\Table(name="ref_pays")
 */
class Pays
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;


  
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;


     /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="paysDuEntreprise")
     */
    private $repertoires;


     /**
     * @ORM\OneToMany(targetEntity=Actionnaire::class, mappedBy="pays")
     */
    private $actionnaires;


     /**
     * @ORM\OneToMany(targetEntity=Filiales::class, mappedBy="pays")
     */
    private $filiales;

    /**
     * @ORM\OneToMany(targetEntity=NiPersonne::class, mappedBy="nationalite")
     */
    private $niPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class, mappedBy="ninNationalite")
     */
    private $niDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="ninNationalite")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiPersonne::class, mappedBy="nationalite")
     */
    private $historyNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="ninNationalite")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="nationalite")
     */
    private $tempNiPersonnes;


    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
        $this->actionnaires = new ArrayCollection();
        $this->filiales = new ArrayCollection();
        $this->niPersonnes = new ArrayCollection();
        $this->niDirigeants = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNiPersonnes = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }


    public function getId(): ?string
    {
        return $this->id;
    }


     public function getCodeLibelle(): ?string
    {
        return $this->id."-".$this->libelle;
    }

    /**
     * @return Collection|Repertoires[]
     */
    public function getRepertoire()
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setPaysDuEntreprise($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getPaysDuEntreprise() === $this) {
                $repertoire->setPaysDuEntreprise(null);
            }
        }

        return $this;
    }


       /**
     * @return Collection|Actionnaire[]
     */
    public function getActionnaire(): Collection
    {
        return $this->actionnaires;
    }

    public function addActionnaire(Actionnaire $actionnaire): self
    {
        if (!$this->actionnaires->contains($actionnaire)) {
            $this->actionnaires[] = $actionnaire;
            $actionnaire->setPays($this);
        }

        return $this;
    }

    public function removeActionnaire(Actionnaire $actionnaire): self
    {
        if ($this->actionnaires->removeElement($actionnaire)) {
            // set the owning side to null (unless already changed)
            if ($actionnaire->getPays() === $this) {
                $actionnaire->setPays(null);
            }
        }

        return $this;
    }



      /**
     * @return Collection|Filiales[]
     */
    public function getFiliales(): Collection
    {
        return $this->filiales;
    }

    public function addFiliale(Filiales $filiale): self
    {
        if (!$this->filiales->contains($filiale)) {
            $this->filiales[] = $filiale;
            $filiales->setPays($this);
        }

        return $this;
    }

    public function removeFiliales(Filiales $filiale): self
    {
        if ($this->filiales->removeElement($filiale)) {
            // set the owning side to null (unless already changed)
            if ($filiale->getPays() === $this) {
                $filiale->setPays(null);
            }
        }

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
     * @return Collection|Repertoire[]
     */
    public function getRepertoires(): Collection
    {
        return $this->repertoires;
    }

    /**
     * @return Collection|Actionnaire[]
     */
    public function getActionnaires(): Collection
    {
        return $this->actionnaires;
    }

    public function removeFiliale(Filiales $filiale): self
    {
        if ($this->filiales->removeElement($filiale)) {
            // set the owning side to null (unless already changed)
            if ($filiale->getPays() === $this) {
                $filiale->setPays(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiPersonne>
     */
    public function getNiPersonnes(): Collection
    {
        return $this->niPersonnes;
    }

    public function addNiPersonne(NiPersonne $niPersonne): self
    {
        if (!$this->niPersonnes->contains($niPersonne)) {
            $this->niPersonnes[] = $niPersonne;
            $niPersonne->setNationalite($this);
        }

        return $this;
    }

    public function removeNiPersonne(NiPersonne $niPersonne): self
    {
        if ($this->niPersonnes->removeElement($niPersonne)) {
            // set the owning side to null (unless already changed)
            if ($niPersonne->getNationalite() === $this) {
                $niPersonne->setNationalite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiDirigeant>
     */
    public function getNiDirigeants(): Collection
    {
        return $this->niDirigeants;
    }

    public function addNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if (!$this->niDirigeants->contains($niDirigeant)) {
            $this->niDirigeants[] = $niDirigeant;
            $niDirigeant->setNinNationalite($this);
        }

        return $this;
    }

    public function removeNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if ($this->niDirigeants->removeElement($niDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($niDirigeant->getNinNationalite() === $this) {
                $niDirigeant->setNinNationalite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiDirigeant>
     */
    public function getHistoryNiDirigeants(): Collection
    {
        return $this->historyNiDirigeants;
    }

    public function addHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if (!$this->historyNiDirigeants->contains($historyNiDirigeant)) {
            $this->historyNiDirigeants[] = $historyNiDirigeant;
            $historyNiDirigeant->setNinNationalite($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNinNationalite() === $this) {
                $historyNiDirigeant->setNinNationalite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiPersonne>
     */
    public function getHistoryNiPersonnes(): Collection
    {
        return $this->historyNiPersonnes;
    }

    public function addHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if (!$this->historyNiPersonnes->contains($historyNiPersonne)) {
            $this->historyNiPersonnes[] = $historyNiPersonne;
            $historyNiPersonne->setNationalite($this);
        }

        return $this;
    }

    public function removeHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if ($this->historyNiPersonnes->removeElement($historyNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($historyNiPersonne->getNationalite() === $this) {
                $historyNiPersonne->setNationalite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiDirigeant>
     */
    public function getTempNiDirigeants(): Collection
    {
        return $this->tempNiDirigeants;
    }

    public function addTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if (!$this->tempNiDirigeants->contains($tempNiDirigeant)) {
            $this->tempNiDirigeants[] = $tempNiDirigeant;
            $tempNiDirigeant->setNinNationalite($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNinNationalite() === $this) {
                $tempNiDirigeant->setNinNationalite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiPersonne>
     */
    public function getTempNiPersonnes(): Collection
    {
        return $this->tempNiPersonnes;
    }

    public function addTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if (!$this->tempNiPersonnes->contains($tempNiPersonne)) {
            $this->tempNiPersonnes[] = $tempNiPersonne;
            $tempNiPersonne->setNationalite($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getNationalite() === $this) {
                $tempNiPersonne->setNationalite(null);
            }
        }

        return $this;
    }
}
