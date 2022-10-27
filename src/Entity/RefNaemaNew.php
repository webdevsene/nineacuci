<?php

namespace App\Entity;

use App\Repository\RefNaemaNewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RefNaemaNewRepository::class)
 */
class RefNaemaNew
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryNaema::class, inversedBy="refNaemaNews")
     */
    private $categoryNaema;

    /**
     * @ORM\OneToMany(targetEntity=Naema::class, mappedBy="refNaemaNew")
     */
    private $naema;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    public function __construct()
    {
        $this->naema = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCategoryNaema(): ?CategoryNaema
    {
        return $this->categoryNaema;
    }

    public function setCategoryNaema(?CategoryNaema $categoryNaema): self
    {
        $this->categoryNaema = $categoryNaema;

        return $this;
    }

    /**
     * @return Collection<string, Naema>
     */
    public function getNaema(): Collection
    {
        return $this->naema;
    }

    public function addNaema(Naema $naema): self
    {
        if (!$this->naema->contains($naema)) {
            $this->naema[] = $naema;
            $naema->setRefNaemaNew($this);
        }

        return $this;
    }

    public function removeNaema(Naema $naema): self
    {
        if ($this->naema->removeElement($naema)) {
            // set the owning side to null (unless already changed)
            if ($naema->getRefNaemaNew() === $this) {
                $naema->setRefNaemaNew(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
