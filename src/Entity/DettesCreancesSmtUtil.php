<?php

namespace App\Entity;

use App\Repository\DettesCreancesSmtUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DettesCreancesSmtUtilRepository::class)
 * @ORM\Table(name="`cuci_etat_des_dettes_creances_smt_util`")
 */
class DettesCreancesSmtUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=DettesCreancesSmt::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="dettesCreancesSmtUtil")
     */
    private $dettesCreancesSmts;

    public function __construct()
    {
        $this->dettesCreancesSmts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, DettesCreancesSmt>
     */
    public function getDettesCreancesSmts(): Collection
    {
        return $this->dettesCreancesSmts;
    }

    public function addDettesCreancesSmt(DettesCreancesSmt $dettesCreancesSmt): self
    {
        if (!$this->dettesCreancesSmts->contains($dettesCreancesSmt)) {
            $this->dettesCreancesSmts[] = $dettesCreancesSmt;
            $dettesCreancesSmt->setDettesCreancesSmtUtil($this);
        }

        return $this;
    }

    public function removeDettesCreancesSmt(DettesCreancesSmt $dettesCreancesSmt): self
    {
        if ($this->dettesCreancesSmts->removeElement($dettesCreancesSmt)) {
            // set the owning side to null (unless already changed)
            if ($dettesCreancesSmt->getDettesCreancesSmtUtil() === $this) {
                $dettesCreancesSmt->setDettesCreancesSmtUtil(null);
            }
        }

        return $this;
    }
}
