<?php

namespace App\Entity;

use App\Repository\FormeJuridiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;



/**
 * @ORM\Entity(repositoryClass=FormeJuridiqueRepository::class)
 * @ORM\Table(name="cuci_formejuridique")
 * 
 */
class FormeJuridique
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $id;

    

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="formeJuridique")
     */
    private $repertoires;

    
    

    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
        $this->id = uniqid();
      
    }

    /**
     * @Route("Route", name="RouteName")
     */
    public function __toString()
    {
        return $this->libelle;   
    }

    public function getId(): ?string
    {
        return $this->id;
    }  


    public function getCodeLibelle(): ?string
    {
        return $this->id."-".$this->libelle;
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
            $repertoire->setFormeJuridique($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getFormeJuridique() === $this) {
                $repertoire->setFormeJuridique(null);
            }
        }

        return $this;
    }

   
  
}
