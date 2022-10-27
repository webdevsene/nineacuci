<?php

namespace App\Entity;

use App\Repository\EtatDesStocksSmtUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatDesStocksSmtUtilRepository::class)
 * @ORM\Table(name="`cuci_etat_des_stocks_smt_util`")
 */
class EtatDesStocksSmtUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=EtatDesStocksSmt::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="etatDesStocksSmtUtil")
     */
    private $etatDesStocksSmts;

    public function __construct()
    {
        $this->etatDesStocksSmts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, EtatDesStocksSmt>
     */
    public function getEtatDesStocksSmts(): Collection
    {
        return $this->etatDesStocksSmts;
    }

    public function addEtatDesStocksSmt(EtatDesStocksSmt $etatDesStocksSmt): self
    {
        if (!$this->etatDesStocksSmts->contains($etatDesStocksSmt)) {
            $this->etatDesStocksSmts[] = $etatDesStocksSmt;
            $etatDesStocksSmt->setEtatDesStocksSmtUtil($this);
        }

        return $this;
    }

    public function removeEtatDesStocksSmt(EtatDesStocksSmt $etatDesStocksSmt): self
    {
        if ($this->etatDesStocksSmts->removeElement($etatDesStocksSmt)) {
            // set the owning side to null (unless already changed)
            if ($etatDesStocksSmt->getEtatDesStocksSmtUtil() === $this) {
                $etatDesStocksSmt->setEtatDesStocksSmtUtil(null);
            }
        }

        return $this;
    }
}
