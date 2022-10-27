<?php

namespace App\Entity;

use App\Repository\NiCiviliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiCiviliteRepository::class)
 */
class NiCivilite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)

     */
    private $id;

    /**
     * @ORM\Column(type="string",nullable=true, name="nin_Civlibelle")
     */
    private $civlibelle;

  
    


    /**
     * @ORM\OneToMany(targetEntity=NiPersonne::class, mappedBy="civilite")
     */
    private $niPersonnes;

   
 /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class, mappedBy="ninCivilite")
     */
    private $ninDirigeant;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="ninCivilite")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiPersonne::class, mappedBy="civilite")
     */
    private $historyNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="ninCivilite")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="civilite")
     */
    private $tempNiPersonnes;
 

    public function __construct()
    {
        $this->niPersonnes = new ArrayCollection();
        $this->ninDirigeant = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNiPersonnes = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
        
    }

    
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCivcode(): ?string
    {
        return $this->civcode;
    }

    public function setCivcode(?string $civcode): self
    {
        $this->civcode = $civcode;

        return $this;
    }

    public function getCivlibelle(): ?string
    {
        return $this->civlibelle;
    }

    public function setCivlibelle(?string $civlibelle): self
    {
        $this->civlibelle = $civlibelle;

        return $this;
    }

    
    public function __toString()
    {
        return $this->civlibelle;
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
            $niPersonne->setCivilite($this);
        }

        return $this;
    }

    public function removeNiPersonne(NiPersonne $niPersonne): self
    {
        if ($this->niPersonnes->removeElement($niPersonne)) {
            // set the owning side to null (unless already changed)
            if ($niPersonne->getCivilite() === $this) {
                $niPersonne->setCivilite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiDirigeant>
     */
    public function getNinDirigeant(): Collection
    {
        return $this->ninDirigeant;
    }

    public function addNinDirigeant(NiDirigeant $ninDirigeant): self
    {
        if (!$this->ninDirigeant->contains($ninDirigeant)) {
            $this->ninDirigeant[] = $ninDirigeant;
            $ninDirigeant->setNinCivilite($this);
        }

        return $this;
    }

    public function removeNinDirigeant(NiDirigeant $ninDirigeant): self
    {
        if ($this->ninDirigeant->removeElement($ninDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($ninDirigeant->getNinCivilite() === $this) {
                $ninDirigeant->setNinCivilite(null);
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
            $historyNiDirigeant->setNinCivilite($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNinCivilite() === $this) {
                $historyNiDirigeant->setNinCivilite(null);
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
            $historyNiPersonne->setCivilite($this);
        }

        return $this;
    }

    public function removeHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if ($this->historyNiPersonnes->removeElement($historyNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($historyNiPersonne->getCivilite() === $this) {
                $historyNiPersonne->setCivilite(null);
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
            $tempNiDirigeant->setNinCivilite($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNinCivilite() === $this) {
                $tempNiDirigeant->setNinCivilite(null);
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
            $tempNiPersonne->setCivilite($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getCivilite() === $this) {
                $tempNiPersonne->setCivilite(null);
            }
        }

        return $this;
    }

   


}
