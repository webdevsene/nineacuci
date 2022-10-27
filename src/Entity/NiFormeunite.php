<?php

namespace App\Entity;

use App\Repository\NiFormeuniteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=NiFormeuniteRepository::class)
 * @UniqueEntity(fields={"id"}, message="Le code doit etre unique.")
 */
class NiFormeunite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=20, unique=true)
     *  @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     *  @Assert\Length(min=2,max=2, minMessage="Ce champ doit contenir deux caractéres",maxMessage="Ce champ doit contenir deux caractéres")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true, name="nin_libelle")
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=NiFormejuridique::class, mappedBy="niFormeunite")
     */
    private $regimeJuridique;


    public function __construct()
    {
        $this->regimeJuridique = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
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
     * @return Collection<int, NiFormejuridique>
     */
    public function getRegimeJuridique(): Collection
    {
        return $this->regimeJuridique;
    }

    public function addRegimeJuridique(NiFormejuridique $regimeJuridique): self
    {
        if (!$this->regimeJuridique->contains($regimeJuridique)) {
            $this->regimeJuridique[] = $regimeJuridique;
            $regimeJuridique->setNiFormeunite($this);
        }

        return $this;
    }

    public function removeRegimeJuridique(NiFormejuridique $regimeJuridique): self
    {
        if ($this->regimeJuridique->removeElement($regimeJuridique)) {
            // set the owning side to null (unless already changed)
            if ($regimeJuridique->getNiFormeunite() === $this) {
                $regimeJuridique->setNiFormeunite(null);
            }
        }

        return $this;
    }


}
