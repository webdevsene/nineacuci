<?php

namespace App\Entity;

use App\Repository\NinTypedocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NinTypedocumentsRepository::class)
 */
class NinTypedocuments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="niTypedocument")
     */
    private $niNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="niTypedocument")
     */
    private $nINineas;

    public function __construct()
    {
        $this->niNineapropositions = new ArrayCollection();
        $this->nINineas = new ArrayCollection();
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

    /**
     * @return Collection<int, NiNineaproposition>
     */
    public function getNiNineapropositions(): Collection
    {
        return $this->niNineapropositions;
    }

    public function addNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if (!$this->niNineapropositions->contains($niNineaproposition)) {
            $this->niNineapropositions[] = $niNineaproposition;
            $niNineaproposition->setNiTypedocument($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getNiTypedocument() === $this) {
                $niNineaproposition->setNiTypedocument(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NINinea>
     */
    public function getNINineas(): Collection
    {
        return $this->nINineas;
    }

    public function addNINinea(NINinea $nINinea): self
    {
        if (!$this->nINineas->contains($nINinea)) {
            $this->nINineas[] = $nINinea;
            $nINinea->setNiTypedocument($this);
        }

        return $this;
    }

    public function removeNINinea(NINinea $nINinea): self
    {
        if ($this->nINineas->removeElement($nINinea)) {
            // set the owning side to null (unless already changed)
            if ($nINinea->getNiTypedocument() === $this) {
                $nINinea->setNiTypedocument(null);
            }
        }

        return $this;
    }
}
