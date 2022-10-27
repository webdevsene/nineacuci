<?php

namespace App\Entity;

use App\Repository\NiParametrageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiParametrageRepository::class)
 */
class NiParametrage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)

     */
    private $id;

    /**
     * @ORM\Column(name="nomServeur",type="string", length=50, nullable=true)
     */
    private $nomServeur;

    /**
     * @ORM\Column(name="adresseServeur",type="string", length=100, nullable=true)
     */
    private $adresseServeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomServeur(): ?string
    {
        return $this->nomServeur;
    }

    public function setNomServeur(?string $nomServeur): self
    {
        $this->nomServeur = $nomServeur;

        return $this;
    }

    public function getAdresseServeur(): ?string
    {
        return $this->adresseServeur;
    }

    public function setAdresseServeur(?string $adresseServeur): self
    {
        $this->adresseServeur = $adresseServeur;

        return $this;
    }

    public function __toString()
    {
        return $this->nomServeur;
    }

}
