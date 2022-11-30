<?php

namespace App\Entity;

use App\Repository\NiTypeConsequenceRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiTypeConsequenceRepository::class)
 */
class NiTypeConsequence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=NiCessation::class, mappedBy="ninConsequences")
     */
    private $niCessations;

    public function __construct()
    {
        $this->niCessations = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * 
     */
    public function __toString(): string
    {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, NiCessation>
     */
    public function getNiCessations(): Collection
    {
        return $this->niCessations;
    }

    public function addNiCessation(NiCessation $niCessation): self
    {
        if (!$this->niCessations->contains($niCessation)) {
            $this->niCessations[] = $niCessation;
            $niCessation->setNinConsequences($this);
        }

        return $this;
    }

    public function removeNiCessation(NiCessation $niCessation): self
    {
        if ($this->niCessations->removeElement($niCessation)) {
            // set the owning side to null (unless already changed)
            if ($niCessation->getNinConsequences() === $this) {
                $niCessation->setNinConsequences(null);
            }
        }

        return $this;
    }
}
