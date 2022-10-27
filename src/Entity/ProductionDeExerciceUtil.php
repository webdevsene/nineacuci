<?php

namespace App\Entity;

use App\Repository\ProductionDeExerciceUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductionDeExerciceUtilRepository::class)
 */
class ProductionDeExerciceUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=ProductionDeExercice::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="productionDeExerciceUtil")
     */
    private $productionDeExercices;

    public function __construct()
    {
        $this->productionDeExercices = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ProductionDeExercice>
     */
    public function getProductionDeExercices(): Collection
    {
        return $this->productionDeExercices;
    }

    public function addProductionDeExercice(ProductionDeExercice $productionDeExercice): self
    {
        if (!$this->productionDeExercices->contains($productionDeExercice)) {
            $this->productionDeExercices[] = $productionDeExercice;
            $productionDeExercice->setProductionDeExerciceUtil($this);
        }

        return $this;
    }

    public function removeProductionDeExercice(ProductionDeExercice $productionDeExercice): self
    {
        if ($this->productionDeExercices->removeElement($productionDeExercice)) {
            // set the owning side to null (unless already changed)
            if ($productionDeExercice->getProductionDeExerciceUtil() === $this) {
                $productionDeExercice->setProductionDeExerciceUtil(null);
            }
        }

        return $this;
    }


}
