<?php

namespace App\Entity;

use App\Repository\NinproduitsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NinproduitsRepository::class)
 * @Gedmo\Loggable
 */
class Ninproduits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
  

    /**
     * @ORM\ManyToOne(targetEntity=RefProduits::class, inversedBy="ninproduits")
     */
    private $refproduits;

    /**
     * @ORM\ManyToOne(targetEntity=NiNineaproposition::class, inversedBy="ninproduits")
     */
    private $nineaproposition;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="ninproduits")
     * @Gedmo\Versioned 
     */
    private $nINinea;

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function __toString()
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

    public function getNineaproposition(): ?NiNineaproposition
    {
        return $this->nineaproposition;
    }

    public function setNineaproposition(?NiNineaproposition $nineaproposition): self
    {
        $this->nineaproposition = $nineaproposition;

        return $this;
    }

    public function getNINinea(): ?NINinea
    {
        return $this->nINinea;
    }

    public function setNINinea(?NINinea $nINinea): self
    {
        $this->nINinea = $nINinea;

        return $this;
    }
}