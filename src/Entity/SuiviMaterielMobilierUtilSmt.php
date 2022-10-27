<?php

namespace App\Entity;

use App\Repository\SuiviMaterielMobilierUtilSmtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuiviMaterielMobilierUtilSmtRepository::class)
 * @ORM\Table(name="`cuci_suivi_materiel_mobilier_caution_util`")
 */
class SuiviMaterielMobilierUtilSmt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=SuiviMaterielMobilier::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="suiviMaterielMobilierUtilSmt")
     */
    private $suiviMaterielMobiliers;

    public function __construct()
    {
        $this->suiviMaterielMobiliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, SuiviMaterielMobilier>
     */
    public function getSuiviMaterielMobiliers(): Collection
    {
        return $this->suiviMaterielMobiliers;
    }

    public function addSuiviMaterielMobilier(SuiviMaterielMobilier $suiviMaterielMobilier): self
    {
        if (!$this->suiviMaterielMobiliers->contains($suiviMaterielMobilier)) {
            $this->suiviMaterielMobiliers[] = $suiviMaterielMobilier;
            $suiviMaterielMobilier->setSuiviMaterielMobilierUtilSmt($this);
        }

        return $this;
    }

    public function removeSuiviMaterielMobilier(SuiviMaterielMobilier $suiviMaterielMobilier): self
    {
        if ($this->suiviMaterielMobiliers->removeElement($suiviMaterielMobilier)) {
            // set the owning side to null (unless already changed)
            if ($suiviMaterielMobilier->getSuiviMaterielMobilierUtilSmt() === $this) {
                $suiviMaterielMobilier->setSuiviMaterielMobilierUtilSmt(null);
            }
        }

        return $this;
    }
}
