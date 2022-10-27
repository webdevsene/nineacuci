<?php

namespace App\Entity;

use App\Repository\TempNinproduitsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNinproduitsRepository::class)
 */
class TempNinproduits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=RefProduits::class, inversedBy="tempNinproduits")
     */
    private $refproduits;

    /**
     * @ORM\ManyToOne(targetEntity=TempNiNineaproposition::class, inversedBy="tempNinproduits")
     */
    private $nineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class, inversedBy="tempNinproduits")
     */
    private $nINinea;

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

    public function getNineaproposition(): ?TempNiNineaproposition
    {
        return $this->nineaproposition;
    }

    public function setNineaproposition(?TempNiNineaproposition $nineaproposition): self
    {
        $this->nineaproposition = $nineaproposition;

        return $this;
    }

    public function getNINinea(): ?TempNINinea
    {
        return $this->nINinea;
    }

    public function setNINinea(?TempNINinea $nINinea): self
    {
        $this->nINinea = $nINinea;

        return $this;
    }
}
