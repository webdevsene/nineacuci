<?php

namespace App\Entity;

use App\Repository\QualiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QualiteRepository::class)
 */
class Qualite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $libelle;


     /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="fonctionDucontact")
     */
    private $repertoires;



     /**
     * @ORM\OneToMany(targetEntity=Dirigeant::class, mappedBy="position")
     */
    private $dirigeants;



     /**
     * @ORM\OneToMany(targetEntity=MembreConseil::class, mappedBy="position")
     */
    private $membreConseils;


    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
        $this->dirigeants = new ArrayCollection();
        $this->membreConseils = new ArrayCollection();
    }

    public function getCodeLibelle(){

        return $this->code."-".$this->libelle;
    }


      /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoires()
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setFonctionDucontact($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getFonctionDucontact() === $this) {
                $repertoire->setFonctionDucontact(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|Dirigeant[]
     */
    public function getDirigeants()
    {
        return $this->dirigeants;
    }

    public function addDirigeant(Dirigeant $dirigeant): self
    {
        if (!$this->dirigeants->contains($dirigeant)) {
            $this->dirigeants[] = $dirigeant;
            $dirigeant->setPosition($this);
        }

        return $this;
    }

    public function removeDirigeant(Dirigeant $dirigeant): self
    {
        if ($this->dirigeants->removeElement($dirigeant)) {
            // set the owning side to null (unless already changed)
            if ($dirigeant->getPosition() === $this) {
                $dirigeant->setPosition(null);
            }
        }

        return $this;
    }



     /**
     * @return Collection|MembreConseil[]
     */
    public function getMembreConseils()
    {
        return $this->membreConseils;
    }

    public function addMembreConseil(MembreConseil $membreConseil): self
    {
        if (!$this->membreConseils->contains($membreConseil)) {
            $this->membreConseils[] = $membreConseil;
            $membreConseil->setPosition($this);
        }

        return $this;
    }

    public function removeMembreConseil(MembreConseil $membreConseil): self
    {
        if ($this->membreConseils->removeElement($membreConseil)) {
            // set the owning side to null (unless already changed)
            if ($membreConseil->getPosition() === $this) {
                $membreConseil->setPosition(null);
            }
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
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

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
