<?php

namespace App\Entity;

use App\Repository\RefProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RefProduitsRepository::class)
 */
class RefProduits
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMA::class, inversedBy="refProduits")
     */
    private $naema;

  

    /**
     * @ORM\OneToMany(targetEntity=Ninproduits::class, mappedBy="refproduits")
     */
    private $ninproduits;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNinproduits::class, mappedBy="refproduits")
     */
    private $historyNinproduits;

    /**
     * @ORM\OneToMany(targetEntity=TempNinproduits::class, mappedBy="refproduits")
     */
    private $tempNinproduits;

    public function __construct()
    {
        $this->ninproduits = new ArrayCollection();
        $this->historyNinproduits = new ArrayCollection();
        $this->tempNinproduits = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
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

    public function getNaema(): ?NAEMA
    {
        return $this->naema;
    }

    public function setNaema(?NAEMA $naema): self
    {
        $this->naema = $naema;

        return $this;
    }

   

    /**
     * @return Collection<int, Ninproduits>
     */
    public function getNinproduits(): Collection
    {
        return $this->ninproduits;
    }

    public function addNinproduit(Ninproduits $ninproduit): self
    {
        if (!$this->ninproduits->contains($ninproduit)) {
            $this->ninproduits[] = $ninproduit;
            $ninproduit->setRefproduits($this);
        }

        return $this;
    }

    public function removeNinproduit(Ninproduits $ninproduit): self
    {
        if ($this->ninproduits->removeElement($ninproduit)) {
            // set the owning side to null (unless already changed)
            if ($ninproduit->getRefproduits() === $this) {
                $ninproduit->setRefproduits(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNinproduits>
     */
    public function getHistoryNinproduits(): Collection
    {
        return $this->historyNinproduits;
    }

    public function addHistoryNinproduit(HistoryNinproduits $historyNinproduit): self
    {
        if (!$this->historyNinproduits->contains($historyNinproduit)) {
            $this->historyNinproduits[] = $historyNinproduit;
            $historyNinproduit->setRefproduits($this);
        }

        return $this;
    }

    public function removeHistoryNinproduit(HistoryNinproduits $historyNinproduit): self
    {
        if ($this->historyNinproduits->removeElement($historyNinproduit)) {
            // set the owning side to null (unless already changed)
            if ($historyNinproduit->getRefproduits() === $this) {
                $historyNinproduit->setRefproduits(null);
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
            $tempNinproduit->setRefproduits($this);
        }

        return $this;
    }

    public function removeTempNinproduit(TempNinproduits $tempNinproduit): self
    {
        if ($this->tempNinproduits->removeElement($tempNinproduit)) {
            // set the owning side to null (unless already changed)
            if ($tempNinproduit->getRefproduits() === $this) {
                $tempNinproduit->setRefproduits(null);
            }
        }

        return $this;
    }
}