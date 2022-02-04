<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=RefAgg::class, mappedBy="category")
     */
    private $refAgg;

    public function __construct()
    {
        $this->refAgg = new ArrayCollection();
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
     * @return Collection|RefAgg[]
     */
    public function getRefAgg(): Collection
    {
        return $this->refAgg;
    }

    public function addRefAgg(RefAgg $refAgg): self
    {
        if (!$this->refAgg->contains($refAgg)) {
            $this->refAgg[] = $refAgg;
            $refAgg->setCategory($this);
        }

        return $this;
    }

    public function removeRefAgg(RefAgg $refAgg): self
    {
        if ($this->refAgg->removeElement($refAgg)) {
            // set the owning side to null (unless already changed)
            if ($refAgg->getCategory() === $this) {
                $refAgg->setCategory(null);
            }
        }

        return $this;
    }
}
