<?php

namespace App\Entity;

use App\Repository\CategoryNaemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CategoryNaemaRepository::class)
 */
class CategoryNaema
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
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Naema::class, mappedBy="categoryNaema")
     */
    private $naema;

    public function __construct()
    {
        $this->naema = new ArrayCollection();
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
     * @return Collection|Naema[]
     */
    public function getNaema(): Collection
    {
        return $this->naema;
    }

    public function addNaema(Naema $naema): self
    {
        if (!$this->naema->contains($naema)) {
            $this->naema[] = $naema;
            $naema->setCategoryNaema($this);
        }

        return $this;
    }

    public function removeNaema(Naema $naema): self
    {
        if ($this->naema->removeElement($naema)) {
            // set the owning side to null (unless already changed)
            if ($naema->getCategoryNaema() === $this) {
                $naema->setCategoryNaema(null);
            }
        }

        return $this;
    }
}
