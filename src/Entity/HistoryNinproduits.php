<?php

namespace App\Entity;

use App\Repository\HistoryNinproduitsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryNinproduitsRepository::class)
 */
class HistoryNinproduits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RefProduits::class, inversedBy="historyNinproduits")
     */
    private $refproduits;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNiNineaproposition::class, inversedBy="historyNinproduits")
     * @ORM\JoinColumn(name="history_ni_nineaproposition_id", referencedColumnName="id")
     */
    private $nineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=HistoryNINinea::class, inversedBy="historyNinproduits")
     * @ORM\JoinColumn(name="history_ni_ninea_id", referencedColumnName="id")
     */
    private $niNinea;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefproduits(): ?RefProduits
    {
        return $this->refproduits;
    }

    public function setRefproduits(?RefProduits $refproduits): self
    {
        $this->refproduits = $refproduits;

        return $this;
    }

    public function getNineaproposition(): ?HistoryNiNineaproposition
    {
        return $this->nineaproposition;
    }

    public function setNineaproposition(?HistoryNiNineaproposition $nineaproposition): self
    {
        $this->nineaproposition = $nineaproposition;

        return $this;
    }

    public function getNiNinea(): ?HistoryNINinea
    {
        return $this->niNinea;
    }

    public function setNiNinea(?HistoryNINinea $niNinea): self
    {
        $this->niNinea = $niNinea;

        return $this;
    }
}
