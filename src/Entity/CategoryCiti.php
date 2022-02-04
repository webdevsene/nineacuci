<?php

namespace App\Entity;

use App\Repository\CategoryCitiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CategoryCitiRepository::class)
 */
class CategoryCiti
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Citi::class, mappedBy="categoryCiti")
     */
    private $citi;

    public function __construct()
    {
        $this->citi = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

      public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }


    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Citi[]
     */
    public function getCiti(): Collection
    {
        return $this->citi;
    }

    public function addCiti(Citi $citi): self
    {
        if (!$this->citi->contains($citi)) {
            $this->citi[] = $citi;
            $citi->setCategoryCiti($this);
        }

        return $this;
    }

    public function removeCiti(Citi $citi): self
    {
        if ($this->citi->removeElement($citi)) {
            // set the owning side to null (unless already changed)
            if ($citi->getCategoryCiti() === $this) {
                $citi->setCategoryCiti(null);
            }
        }

        return $this;
    }
}
