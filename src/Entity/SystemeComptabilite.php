<?php

namespace App\Entity;

use App\Repository\SystemeComptabiliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SystemeComptabiliteRepository::class)
 *  @ORM\Table(name="`cuci_systeme_comptabilite`")
 */
class SystemeComptabilite
{
     /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="systemeComptabilite")
     */
    private $repertoire;

    public function __construct()
    {
        $this->repertoire = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->libelle;
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
    public function getRepertoire(): Collection
    {
        return $this->repertoire;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoire->contains($repertoire)) {
            $this->repertoire[] = $repertoire;
            $repertoire->setSystemeComptabilite($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getSystemeComptabilite() === $this) {
                $repertoire->setSystemeComptabilite(null);
            }
        }

        return $this;
    }
}
