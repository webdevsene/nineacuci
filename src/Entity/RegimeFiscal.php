<?php

namespace App\Entity;

use App\Repository\RegimeFiscalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=RegimeFiscalRepository::class)
 * @ORM\Table(name="cuci_regimefiscal")
 */
class RegimeFiscal
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="regimeFiscal")
     */
    private $repertoires;

    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
         $this->id = uniqid();
    }

    public function __toString()
    {
        return $this->libelle;
    }


     public function getCodeLibelle(): ?string
    {
        return $this->id."-".$this->libelle;
    }


    public function getId(): ?int
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
     * @return Collection|Repertoire[]
     */
    public function getRepertoires(): Collection
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setRegimeFiscal($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getRegimeFiscal() === $this) {
                $repertoire->setRegimeFiscal(null);
            }
        }

        return $this;
    }
}
