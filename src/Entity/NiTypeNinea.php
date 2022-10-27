<?php

namespace App\Entity;

use App\Repository\NiTypeNineaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiTypeNineaRepository::class)
 */
class NiTypeNinea
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $ninLibelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinLibelle(): ?string
    {
        return $this->ninLibelle;
    }

    public function setNinLibelle(string $ninLibelle): self
    {
        $this->ninLibelle = $ninLibelle;

        return $this;
    }

    public function __toString()
    {
        return $this->ninLibelle;
    }

}
