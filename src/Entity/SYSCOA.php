<?php

namespace App\Entity;

use App\Repository\SYSCOARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SYSCOARepository::class)
 */
class SYSCOA
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
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="sYSCOA")
     */
    private $activite;


    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="syscoa")
     */
    private $repertoires;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $codeSyscoa;

    /**
     * @ORM\ManyToOne(targetEntity=CategorySyscoa::class, inversedBy="syscoa")
     */
    private $categorySyscoa;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $CODE004;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $CODE09;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $CODE_ACTIVITE;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $LIBELLE004;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $LIBELLE09;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CODE_NAEMA;

    public function __construct()
    {
        $this->activite = new ArrayCollection();
        $this->repertoires = new ArrayCollection();
    }


     /**
     * toString
     * @return string 
     */
    public  function __toString()
    {
        return $this->libelle;
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
            $repertoire->setSYSCOA($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getSYSCOA() === $this) {
                $repertoire->setSYSCOA(null);
            }
        }

        return $this;
    }


    public function getId(): ?string
    {
        return $this->id;
    }


     public function getSyscoa(): ?string
    {
        return  $this->codeSyscoa."-".$this->libelle;
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
    public function getActivite(): Collection
    {
        return $this->activite;
    }

    public function addActivite(Activities $activite): self
    {
        if (!$this->activite->contains($activite)) {
            $this->activite[] = $activite;
            $activite->setSYSCOA($this);
        }

        return $this;
    }

    public function removeActivite(Activities $activite): self
    {
        if ($this->activite->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getSYSCOA() === $this) {
                $activite->setSYSCOA(null);
            }
        }

        return $this;
    }

    public function getCodeSyscoa(): ?string
    {
        return $this->codeSyscoa;
    }

    public function setCodeSyscoa(?string $codeSyscoa): self
    {
        $this->codeSyscoa = $codeSyscoa;

        return $this;
    }

    public function getCategorySyscoa(): ?CategorySyscoa
    {
        return $this->categorySyscoa;
    }

    public function setCategorySyscoa(?CategorySyscoa $categorySyscoa): self
    {
        $this->categorySyscoa = $categorySyscoa;

        return $this;
    }

    public function getCODE004(): ?string
    {
        return $this->CODE004;
    }

    public function setCODE004(?string $CODE004): self
    {
        $this->CODE004 = $CODE004;

        return $this;
    }

    public function getCODE09(): ?string
    {
        return $this->CODE09;
    }

    public function setCODE09(?string $CODE09): self
    {
        $this->CODE09 = $CODE09;

        return $this;
    }

    public function getCODEACTIVITE(): ?string
    {
        return $this->CODE_ACTIVITE;
    }

    public function setCODEACTIVITE(?string $CODE_ACTIVITE): self
    {
        $this->CODE_ACTIVITE = $CODE_ACTIVITE;

        return $this;
    }

    public function getLIBELLE004(): ?string
    {
        return $this->LIBELLE004;
    }

    public function setLIBELLE004(?string $LIBELLE004): self
    {
        $this->LIBELLE004 = $LIBELLE004;

        return $this;
    }

    public function getLIBELLE09(): ?string
    {
        return $this->LIBELLE09;
    }

    public function setLIBELLE09(?string $LIBELLE09): self
    {
        $this->LIBELLE09 = $LIBELLE09;

        return $this;
    }

    public function getCODENAEMA(): ?string
    {
        return $this->CODE_NAEMA;
    }

    public function setCODENAEMA(?string $CODE_NAEMA): self
    {
        $this->CODE_NAEMA = $CODE_NAEMA;

        return $this;
    }

    /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoires(): Collection
    {
        return $this->repertoires;
    }
}
