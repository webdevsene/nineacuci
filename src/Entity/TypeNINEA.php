<?php

namespace App\Entity;

use App\Repository\TypeNINEARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeNINEARepository::class)
 */
class TypeNINEA
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="typeNINEA")
     */
    private $repertoires;

    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
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
            $repertoire->setTypeNINEA($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getTypeNINEA() === $this) {
                $repertoire->setTypeNINEA(null);
            }
        }

        return $this;
    }
}
