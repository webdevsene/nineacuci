<?php

namespace App\Entity;

use App\Repository\RefCategoryCitiNewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RefCategoryCitiNewRepository::class)
 */
class RefCategoryCitiNew
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryCiti::class, inversedBy="refCategoryCitiNews")
     */
    private $categorieCiti;

    /**
     * @ORM\OneToMany(targetEntity=Citi::class, mappedBy="refCategoryCitiNew")
     */
    private $citi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    public function __construct()
    {
        $this->citi = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCategorieCiti(): ?CategoryCiti
    {
        return $this->categorieCiti;
    }

    public function setCategorieCiti(?CategoryCiti $categorieCiti): self
    {
        $this->categorieCiti = $categorieCiti;

        return $this;
    }

    /**
     * @return Collection<string, Citi>
     */
    public function getCiti(): Collection
    {
        return $this->citi;
    }

    public function addCiti(Citi $citi): self
    {
        if (!$this->citi->contains($citi)) {
            $this->citi[] = $citi;
            $citi->setRefCategoryCitiNew($this);
        }

        return $this;
    }

    public function removeCiti(Citi $citi): self
    {
        if ($this->citi->removeElement($citi)) {
            // set the owning side to null (unless already changed)
            if ($citi->getRefCategoryCitiNew() === $this) {
                $citi->setRefCategoryCitiNew(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
