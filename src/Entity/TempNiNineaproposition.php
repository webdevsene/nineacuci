<?php

namespace App\Entity;

use App\Repository\TempNiNineapropositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiNineapropositionRepository::class)
 */
class TempNiNineaproposition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

   

    /**
     * @ORM\OneToMany(targetEntity=TempNiActiviteEconomique::class, mappedBy="niNineaproposition")
     */
    private $tempNiActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=TempNiCoordonnees::class, mappedBy="niNineaproposition")
     */
    private $tempNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="ninNineaProposition")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="niNineapropositions")
     */
    private $tempNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNinproduits::class, mappedBy="nineaproposition")
     */
    private $tempNinproduits;

    public function __construct()
    {
       
        
        $this->tempNiActiviteEconomiques = new ArrayCollection();
        $this->tempNiCoordonnees = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
        $this->tempNinproduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $tempNiActiviteEconomique->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeTempNiActiviteEconomique(TempNiActiviteEconomique $tempNiActiviteEconomique): self
    {
        if ($this->tempNiActiviteEconomiques->removeElement($tempNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActiviteEconomique->getNiNineaproposition() === $this) {
                $tempNiActiviteEconomique->setNiNineaproposition(null);
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
            $tempNiCoordonnee->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if ($this->tempNiCoordonnees->removeElement($tempNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCoordonnee->getNiNineaproposition() === $this) {
                $tempNiCoordonnee->setNiNineaproposition(null);
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
            $tempNiDirigeant->setNinNineaProposition($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNinNineaProposition() === $this) {
                $tempNiDirigeant->setNinNineaProposition(null);
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
            $tempNiPersonne->setNiNineapropositions($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getNiNineapropositions() === $this) {
                $tempNiPersonne->setNiNineapropositions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNinproduits>
     */
    public function getTempNinproduits(): Collection
    {
        return $this->tempNinproduits;
    }

    public function addTempNinproduit(TempNinproduits $tempNinproduit): self
    {
        if (!$this->tempNinproduits->contains($tempNinproduit)) {
            $this->tempNinproduits[] = $tempNinproduit;
            $tempNinproduit->setNineaproposition($this);
        }

        return $this;
    }

    public function removeTempNinproduit(TempNinproduits $tempNinproduit): self
    {
        if ($this->tempNinproduits->removeElement($tempNinproduit)) {
            // set the owning side to null (unless already changed)
            if ($tempNinproduit->getNineaproposition() === $this) {
                $tempNinproduit->setNineaproposition(null);
            }
        }

        return $this;
    }
}
