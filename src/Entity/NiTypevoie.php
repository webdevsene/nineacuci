<?php

namespace App\Entity;

use App\Repository\NiTypevoieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiTypevoieRepository::class)
 */
class NiTypevoie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)

     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="nin_Libelle")
     */
    private $tyvlibelle;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="ninType")
     */
    private $niNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="ninType")
     */
    private $nINineas;

    /**
     * @ORM\OneToMany(targetEntity=NiCoordonnees::class, mappedBy="ninTypeVoie")
     */
    private $niCoordonnees;


    /**
     * @ORM\OneToMany(targetEntity=NiPersonne::class, mappedBy="ninTypevoie")
     */
    private $niPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiCoordonnees::class, mappedBy="ninTypeVoie")
     */
    private $historyNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiPersonne::class, mappedBy="ninTypevoie")
     */
    private $historyNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNiCoordonnees::class, mappedBy="ninTypeVoie")
     */
    private $tempNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="ninTypevoie")
     */
    private $tempNiPersonnes;


    public function __construct()
    {
        $this->niNineapropositions = new ArrayCollection();
        $this->nINineas = new ArrayCollection();
        $this->niCoordonnees = new ArrayCollection();
        
        $this->niPersonnes = new ArrayCollection();
        $this->historyNiCoordonnees = new ArrayCollection();
        $this->historyNiPersonnes = new ArrayCollection();
        $this->tempNiCoordonnees = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
    }



    public function getId(): ?string
    {
        return $this->id;
    }

   
    public function getTyvlibelle(): ?string
    {
        return $this->tyvlibelle;
    }

    public function setTyvlibelle(?string $tyvlibelle): self
    {
        $this->tyvlibelle = $tyvlibelle;

        return $this;
    }

    /**
     * @return Collection<int, NiNineaproposition>
     */
    public function getNiNineapropositions(): Collection
    {
        return $this->niNineapropositions;
    }

    public function addNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if (!$this->niNineapropositions->contains($niNineaproposition)) {
            $this->niNineapropositions[] = $niNineaproposition;
            $niNineaproposition->setNinType($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getNinType() === $this) {
                $niNineaproposition->setNinType(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->tyvlibelle;
    }

    /**
     * @return Collection<int, NINinea>
     */
    public function getNINineas(): Collection
    {
        return $this->nINineas;
    }

    public function addNINinea(NINinea $nINinea): self
    {
        if (!$this->nINineas->contains($nINinea)) {
            $this->nINineas[] = $nINinea;
            $nINinea->setNinType($this);
        }

        return $this;
    }

    public function removeNINinea(NINinea $nINinea): self
    {
        if ($this->nINineas->removeElement($nINinea)) {
            // set the owning side to null (unless already changed)
            if ($nINinea->getNinType() === $this) {
                $nINinea->setNinType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiCoordonnees>
     */
    public function getNiCoordonnees(): Collection
    {
        return $this->niCoordonnees;
    }

    public function addNiCoordonnee(NiCoordonnees $niCoordonnee): self
    {
        if (!$this->niCoordonnees->contains($niCoordonnee)) {
            $this->niCoordonnees[] = $niCoordonnee;
            $niCoordonnee->setNinTypeVoie($this);
        }

        return $this;
    }

    public function removeNiCoordonnee(NiCoordonnees $niCoordonnee): self
    {
        if ($this->niCoordonnees->removeElement($niCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($niCoordonnee->getNinTypeVoie() === $this) {
                $niCoordonnee->setNinTypeVoie(null);
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
            $niPersonne->setNinTypevoie($this);
        }

        return $this;
    }

    public function removeNiPersonne(NiPersonne $niPersonne): self
    {
        if ($this->niPersonnes->removeElement($niPersonne)) {
            // set the owning side to null (unless already changed)
            if ($niPersonne->getNinTypevoie() === $this) {
                $niPersonne->setNinTypevoie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiCoordonnees>
     */
    public function getHistoryNiCoordonnees(): Collection
    {
        return $this->historyNiCoordonnees;
    }

    public function addHistoryNiCoordonnee(HistoryNiCoordonnees $historyNiCoordonnee): self
    {
        if (!$this->historyNiCoordonnees->contains($historyNiCoordonnee)) {
            $this->historyNiCoordonnees[] = $historyNiCoordonnee;
            $historyNiCoordonnee->setNinTypeVoie($this);
        }

        return $this;
    }

    public function removeHistoryNiCoordonnee(HistoryNiCoordonnees $historyNiCoordonnee): self
    {
        if ($this->historyNiCoordonnees->removeElement($historyNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($historyNiCoordonnee->getNinTypeVoie() === $this) {
                $historyNiCoordonnee->setNinTypeVoie(null);
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
            $historyNiPersonne->setNinTypevoie($this);
        }

        return $this;
    }

    public function removeHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if ($this->historyNiPersonnes->removeElement($historyNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($historyNiPersonne->getNinTypevoie() === $this) {
                $historyNiPersonne->setNinTypevoie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiCoordonnees>
     */
    public function getTempNiCoordonnees(): Collection
    {
        return $this->tempNiCoordonnees;
    }

    public function addTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if (!$this->tempNiCoordonnees->contains($tempNiCoordonnee)) {
            $this->tempNiCoordonnees[] = $tempNiCoordonnee;
            $tempNiCoordonnee->setNinTypeVoie($this);
        }

        return $this;
    }

    public function removeTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if ($this->tempNiCoordonnees->removeElement($tempNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCoordonnee->getNinTypeVoie() === $this) {
                $tempNiCoordonnee->setNinTypeVoie(null);
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
            $tempNiPersonne->setNinTypevoie($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getNinTypevoie() === $this) {
                $tempNiPersonne->setNinTypevoie(null);
            }
        }

        return $this;
    }


}
