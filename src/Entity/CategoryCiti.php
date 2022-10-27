<?php

namespace App\Entity;

use App\Repository\CategoryCitiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CategoryCitiRepository::class)
 * @ORM\Table(name="ref_category_citi")
 */
class CategoryCiti
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
     * @ORM\OneToMany(targetEntity=RefCategoryCitiNew::class, mappedBy="categorieCiti")
     */
    private $refCategoryCitiNews;

    public function __construct()
    {
       
        $this->refCategoryCitiNews = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->libelle;
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

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

 
    /**
     * @return Collection<string, RefCategoryCitiNew>
     */
    public function getRefCategoryCitiNews(): Collection
    {
        return $this->refCategoryCitiNews;
    }

    public function addRefCategoryCitiNews(RefCategoryCitiNew $refCategoryCitiNews): self
    {
        if (!$this->refCategoryCitiNews->contains($refCategoryCitiNews)) {
            $this->refCategoryCitiNews[] = $refCategoryCitiNews;
            $refCategoryCitiNews->setCategorieCiti($this);
        }

        return $this;
    }

    public function removeRefCategoryCitiNews(RefCategoryCitiNew $refCategoryCitiNews): self
    {
        if ($this->refCategoryCitiNews->removeElement($refCategoryCitiNews)) {
            // set the owning side to null (unless already changed)
            if ($refCategoryCitiNews->getCategorieCiti() === $this) {
                $refCategoryCitiNews->setCategorieCiti(null);
            }
        }

        return $this;
    }
}
