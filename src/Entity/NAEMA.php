<?php

namespace App\Entity;

use App\Repository\NAEMARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NAEMARepository::class)
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryNaema::class, inversedBy="naema")
     */
    private $categoryNaema;


    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="naema")
     */
    private $repertoires;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
    }


    public function getCodeLibelle(): ?string
    {
        return $this->code."-".$this->libelle;
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
        return  $this->code."-".$this->libelle;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCategoryNaema(): ?CategoryNaema
    {
        return $this->categoryNaema;
    }

    public function setCategoryNaema(?CategoryNaema $categoryNaema): self
    {
        $this->categoryNaema = $categoryNaema;

        return $this;
    }
}
