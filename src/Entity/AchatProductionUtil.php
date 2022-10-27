<?php

namespace App\Entity;

use App\Repository\AchatProductionUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AchatProductionUtilRepository::class)
 *  @ORM\Table(name="`cuci_achat_production_util`")
 */
class AchatProductionUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=AchatProduction::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="achatProductionUtil")
     */
    private $achatProduction;

    public function __construct()
    {
        $this->achatProduction = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, AchatProduction>
     */
    public function getAchatProduction(): Collection
    {
        return $this->achatProduction;
    }

    public function addAchatProduction(AchatProduction $achatProduction): self
    {
        if (!$this->achatProduction->contains($achatProduction)) {
            $this->achatProduction[] = $achatProduction;
            $achatProduction->setAchatProductionUtil($this);
        }

        return $this;
    }

    public function removeAchatProduction(AchatProduction $achatProduction): self
    {
        if ($this->achatProduction->removeElement($achatProduction)) {
            // set the owning side to null (unless already changed)
            if ($achatProduction->getAchatProductionUtil() === $this) {
                $achatProduction->setAchatProductionUtil(null);
            }
        }

        return $this;
    }
}
