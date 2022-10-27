<?php

namespace App\Entity;

use App\Repository\QualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QualiteRepository::class)
 *  @ORM\Table(name="`ref_qualification`")
 * 
 */
class Qualite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $libelle;


     /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="fonctionDucontact")
     */
    private $repertoires;



     /**
     * @ORM\OneToMany(targetEntity=Dirigeant::class, mappedBy="position")
     */
    private $dirigeants;



     /**
     * @ORM\OneToMany(targetEntity=MembreConseil::class, mappedBy="position")
     */
    private $membreConseils;

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class, mappedBy="ninPosition")
     */
    private $niDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="ninPosition")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="ninPosition")
     */
    private $tempNiDirigeants;


    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
        $this->dirigeants = new ArrayCollection();
        $this->membreConseils = new ArrayCollection();
        $this->niDirigeants = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
    }

    public function getCodeLibelle(){

        return $this->id."-".$this->libelle;
    }


      /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoires()
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setFonctionDucontact($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getFonctionDucontact() === $this) {
                $repertoire->setFonctionDucontact(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|Dirigeant[]
     */
    public function getDirigeants()
    {
        return $this->dirigeants;
    }

    public function addDirigeant(Dirigeant $dirigeant): self
    {
        if (!$this->dirigeants->contains($dirigeant)) {
            $this->dirigeants[] = $dirigeant;
            $dirigeant->setPosition($this);
        }

        return $this;
    }

    public function removeDirigeant(Dirigeant $dirigeant): self
    {
        if ($this->dirigeants->removeElement($dirigeant)) {
            // set the owning side to null (unless already changed)
            if ($dirigeant->getPosition() === $this) {
                $dirigeant->setPosition(null);
            }
        }

        return $this;
    }



     /**
     * @return Collection|MembreConseil[]
     */
    public function getMembreConseils()
    {
        return $this->membreConseils;
    }

    public function addMembreConseil(MembreConseil $membreConseil): self
    {
        if (!$this->membreConseils->contains($membreConseil)) {
            $this->membreConseils[] = $membreConseil;
            $membreConseil->setPosition($this);
        }

        return $this;
    }

    public function removeMembreConseil(MembreConseil $membreConseil): self
    {
        if ($this->membreConseils->removeElement($membreConseil)) {
            // set the owning side to null (unless already changed)
            if ($membreConseil->getPosition() === $this) {
                $membreConseil->setPosition(null);
            }
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
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
            $niDirigeant->setNinPosition($this);
        }

        return $this;
    }

    public function removeNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if ($this->niDirigeants->removeElement($niDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($niDirigeant->getNinPosition() === $this) {
                $niDirigeant->setNinPosition(null);
            }
        }

        return $this;
    }


    public function __toString()
    {

            return $this->libelle;
        
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
            $historyNiDirigeant->setNinPosition($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNinPosition() === $this) {
                $historyNiDirigeant->setNinPosition(null);
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
            $tempNiDirigeant->setNinPosition($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNinPosition() === $this) {
                $tempNiDirigeant->setNinPosition(null);
            }
        }

        return $this;
    }
}
