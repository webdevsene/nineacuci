<?php

namespace App\Entity;

use App\Repository\CategoryNaemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CategoryNaemaRepository::class)
 * @ORM\Table(name="ref_category_naema")
 */
class CategoryNaema
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $libelle;

  

    /**
     * @ORM\OneToMany(targetEntity=RefNaemaNew::class, mappedBy="categoryNaema")
     */
    private $refNaemaNews;

    public function __construct()
    {
       
        $this->refNaemaNews = new ArrayCollection();
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
     * @return Collection<int, RefNaemaNew>
     */
    public function getRefNaemaNews(): Collection
    {
        return $this->refNaemaNews;
    }

    public function addRefNaemaNews(RefNaemaNew $refNaemaNews): self
    {
        if (!$this->refNaemaNews->contains($refNaemaNews)) {
            $this->refNaemaNews[] = $refNaemaNews;
            $refNaemaNews->setCategoryNaema($this);
        }

        return $this;
    }

    public function removeRefNaemaNews(RefNaemaNew $refNaemaNews): self
    {
        if ($this->refNaemaNews->removeElement($refNaemaNews)) {
            // set the owning side to null (unless already changed)
            if ($refNaemaNews->getCategoryNaema() === $this) {
                $refNaemaNews->setCategoryNaema(null);
            }
        }

        return $this;
    }
}
