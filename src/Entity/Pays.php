<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaysRepository::class)
 */
class Pays
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $alpha2;

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


    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
        $this->actionnaires = new ArrayCollection();
        $this->filiales = new ArrayCollection();
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



    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAlpha2(): ?string
    {
        return $this->alpha2;
    }

    public function setAlpha2(string $alpha2): self
    {
        $this->alpha2 = $alpha2;

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
}
