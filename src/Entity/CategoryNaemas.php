<?php

namespace App\Entity;

use App\Repository\CategoryNaemasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CategoryNaemasRepository::class)
 */
class CategoryNaemas
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Naemas::class, mappedBy="categoryNaemas")
     */
    private $naemas;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $branche;

    public function __construct()
    {
        $this->naemas = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
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
     * @return Collection|Naemas[]
     */
    public function getNaemas(): Collection
    {
        return $this->naemas;
    }

    public function addNaema(Naemas $naema): self
    {
        if (!$this->naemas->contains($naema)) {
            $this->naemas[] = $naema;
            $naema->setCategoryNaemas($this);
        }

        return $this;
    }

    public function removeNaema(Naemas $naema): self
    {
        if ($this->naemas->removeElement($naema)) {
            // set the owning side to null (unless already changed)
            if ($naema->getCategoryNaemas() === $this) {
                $naema->setCategoryNaemas(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getBranche(): ?string
    {
        return $this->branche;
    }

    public function setBranche(?string $branche): self
    {
        $this->branche = $branche;

        return $this;
    }
}
