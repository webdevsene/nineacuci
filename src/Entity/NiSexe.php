<?php

namespace App\Entity;

use App\Repository\NiSexeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiSexeRepository::class)
 */
class NiSexe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string",  name="nin_Libelle")
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=NiPersonne::class, mappedBy="ninSexe")
     */
    private $niPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class, mappedBy="ninSexe")
     */
    private $niDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="ninSexe")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiPersonne::class, mappedBy="ninSexe")
     */
    private $historyNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="ninSexe")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="ninSexe")
     */
    private $tempNiPersonnes;

    public function __construct()
    {
        $this->niPersonnes = new ArrayCollection();
        $this->niDirigeants = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNiPersonnes = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    


    public function __toString()
    {
        return $this->libelle;
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
            $niPersonne->setNinSexe($this);
        }

        return $this;
    }

    public function removeNiPersonne(NiPersonne $niPersonne): self
    {
        if ($this->niPersonnes->removeElement($niPersonne)) {
            // set the owning side to null (unless already changed)
            if ($niPersonne->getNinSexe() === $this) {
                $niPersonne->setNinSexe(null);
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
            $niDirigeant->setNinSexe($this);
        }

        return $this;
    }

    public function removeNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if ($this->niDirigeants->removeElement($niDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($niDirigeant->getNinSexe() === $this) {
                $niDirigeant->setNinSexe(null);
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
            $historyNiDirigeant->setNinSexe($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNinSexe() === $this) {
                $historyNiDirigeant->setNinSexe(null);
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
            $historyNiPersonne->setNinSexe($this);
        }

        return $this;
    }

    public function removeHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if ($this->historyNiPersonnes->removeElement($historyNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($historyNiPersonne->getNinSexe() === $this) {
                $historyNiPersonne->setNinSexe(null);
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
            $tempNiDirigeant->setNinSexe($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNinSexe() === $this) {
                $tempNiDirigeant->setNinSexe(null);
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
            $tempNiPersonne->setNinSexe($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getNinSexe() === $this) {
                $tempNiPersonne->setNinSexe(null);
            }
        }

        return $this;
    }

   
}
