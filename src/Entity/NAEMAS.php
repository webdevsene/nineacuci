<?php

namespace App\Entity;

use App\Repository\NAEMASRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NAEMASRepository::class)
 */
class NAEMAS
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
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="nAEMAS")
     */
    private $activites;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryNaemas::class, inversedBy="naemas")
     */
    private $categoryNaemas;



    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="naemas")
     */
    private $repertoires;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $branche;

    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
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
            $repertoire->setNaemas($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getNaemas() === $this) {
                $repertoire->setNaemas(null);
            }
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

     public function getNaemas(): ?string
    {
        return  $this->code."-".$this->libelle;
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
            $activite->setNAEMAS($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getNAEMAS() === $this) {
                $activite->setNAEMAS(null);
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

    public function getCategoryNaemas(): ?CategoryNaemas
    {
        return $this->categoryNaemas;
    }

    public function setCategoryNaemas(?CategoryNaemas $categoryNaemas): self
    {
        $this->categoryNaemas = $categoryNaemas;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getBranche(): ?string
    {
        return $this->branche;
    }

    public function setBranche(?string $branche): self
    {
        $this->branche = $branche;

        return $this;
    }
}
