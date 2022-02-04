<?php

namespace App\Entity;

use App\Repository\CitiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CitiRepository::class)
 */
class Citi
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="cITI")
     */
    private $activites;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryCiti::class, inversedBy="citi")
     */
    private $categoryCiti;



    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="citi")
     */
    private $repertoires;


    public function __construct()
    {
        $this->activites = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
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


    public function getCiti(): ?string
    {
        return  $this->code."-".$this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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
            $repertoire->setCiti($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getCiti() === $this) {
                $repertoire->setCiti(null);
            }
        }

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
            $activite->setCITI($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getCITI() === $this) {
                $activite->setCITI(null);
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

    public function getCategoryCiti(): ?CategoryCiti
    {
        return $this->categoryCiti;
    }

    public function setCategoryCiti(?CategoryCiti $categoryCiti): self
    {
        $this->categoryCiti = $categoryCiti;

        return $this;
    }
}
