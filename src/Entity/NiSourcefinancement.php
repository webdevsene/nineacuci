<?php

namespace App\Entity;

use App\Repository\NiSourcefinancementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiSourcefinancementRepository::class)
 */
class NiSourcefinancement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=NiActiviteEconomique::class, mappedBy="ninOcc")
     */
    private $niActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=TempNiActiviteEconomique::class, mappedBy="ninOcc")
     */
    private $tempNiActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActiviteEconomique::class, mappedBy="ninOcc")
     */
    private $historyNiActiviteEconomiques;

    public function __construct()
    {
        $this->niActiviteEconomiques = new ArrayCollection();
        $this->tempNiActiviteEconomiques = new ArrayCollection();
        $this->historyNiActiviteEconomiques = new ArrayCollection();
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

    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @return Collection<int, NiActiviteEconomique>
     */
    public function getNiActiviteEconomiques(): Collection
    {
        return $this->niActiviteEconomiques;
    }

    public function addNiActiviteEconomique(NiActiviteEconomique $niActiviteEconomique): self
    {
        if (!$this->niActiviteEconomiques->contains($niActiviteEconomique)) {
            $this->niActiviteEconomiques[] = $niActiviteEconomique;
            $niActiviteEconomique->setNinOcc($this);
        }

        return $this;
    }

    public function removeNiActiviteEconomique(NiActiviteEconomique $niActiviteEconomique): self
    {
        if ($this->niActiviteEconomiques->removeElement($niActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($niActiviteEconomique->getNinOcc() === $this) {
                $niActiviteEconomique->setNinOcc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiActiviteEconomique>
     */
    public function getTempNiActiviteEconomiques(): Collection
    {
        return $this->tempNiActiviteEconomiques;
    }

    public function addTempNiActiviteEconomique(TempNiActiviteEconomique $tempNiActiviteEconomique): self
    {
        if (!$this->tempNiActiviteEconomiques->contains($tempNiActiviteEconomique)) {
            $this->tempNiActiviteEconomiques[] = $tempNiActiviteEconomique;
            $tempNiActiviteEconomique->setNinOcc($this);
        }

        return $this;
    }

    public function removeTempNiActiviteEconomique(TempNiActiviteEconomique $tempNiActiviteEconomique): self
    {
        if ($this->tempNiActiviteEconomiques->removeElement($tempNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActiviteEconomique->getNinOcc() === $this) {
                $tempNiActiviteEconomique->setNinOcc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiActiviteEconomique>
     */
    public function getHistoryNiActiviteEconomiques(): Collection
    {
        return $this->historyNiActiviteEconomiques;
    }

    public function addHistoryNiActiviteEconomique(HistoryNiActiviteEconomique $historyNiActiviteEconomique): self
    {
        if (!$this->historyNiActiviteEconomiques->contains($historyNiActiviteEconomique)) {
            $this->historyNiActiviteEconomiques[] = $historyNiActiviteEconomique;
            $historyNiActiviteEconomique->setNinOcc($this);
        }

        return $this;
    }

    public function removeHistoryNiActiviteEconomique(HistoryNiActiviteEconomique $historyNiActiviteEconomique): self
    {
        if ($this->historyNiActiviteEconomiques->removeElement($historyNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActiviteEconomique->getNinOcc() === $this) {
                $historyNiActiviteEconomique->setNinOcc(null);
            }
        }

        return $this;
    }

}
