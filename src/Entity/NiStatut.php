<?php

namespace App\Entity;

use App\Repository\NiStatutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=NiStatutRepository::class)
 */
class NiStatut
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)
     * @Groups("statut:read")
     */
    private $id;

 
    /**
     * @ORM\Column(type="string", nullable=true, name="nin_Libelle")
     * @Groups("statut:read")
     */
    private $statLibelle;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="ninStatut")
     */
    private $niNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="ninStatut")
     */
    private $nINineas;

    /**
     * @ORM\OneToMany(targetEntity=TempNINinea::class, mappedBy="ninStatut")
     */
    private $tempNINineas;

    public function __construct()
    {
        $this->niNineapropositions = new ArrayCollection();
        $this->nINineas = new ArrayCollection();
        $this->tempNINineas = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getStatLibelle(): ?string
    {
        return $this->statLibelle;
    }

    public function setStatLibelle(?string $statLibelle): self
    {
        $this->statLibelle = $statLibelle;

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
            $niNineaproposition->setNinStatut($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getNinStatut() === $this) {
                $niNineaproposition->setNinStatut(null);
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
            $nINinea->setNinStatut($this);
        }

        return $this;
    }

    public function removeNINinea(NINinea $nINinea): self
    {
        if ($this->nINineas->removeElement($nINinea)) {
            // set the owning side to null (unless already changed)
            if ($nINinea->getNinStatut() === $this) {
                $nINinea->setNinStatut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNINinea>
     */
    public function getTempNINineas(): Collection
    {
        return $this->tempNINineas;
    }

    public function addTempNINinea(TempNINinea $tempNINinea): self
    {
        if (!$this->tempNINineas->contains($tempNINinea)) {
            $this->tempNINineas[] = $tempNINinea;
            $tempNINinea->setNinStatut($this);
        }

        return $this;
    }

    public function removeTempNINinea(TempNINinea $tempNINinea): self
    {
        if ($this->tempNINineas->removeElement($tempNINinea)) {
            // set the owning side to null (unless already changed)
            if ($tempNINinea->getNinStatut() === $this) {
                $tempNINinea->setNinStatut(null);
            }
        }

        return $this;
    }

 
    
}
