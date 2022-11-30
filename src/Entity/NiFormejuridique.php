<?php

namespace App\Entity;

use App\Repository\NiFormejuridiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=NiFormejuridiqueRepository::class)
 * @UniqueEntity(fields={"id"}, message="Le code doit etre unique.")
 */
class NiFormejuridique
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)
     * @Groups("formejuridique:read")
     *  @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     *  @Assert\Length(max=4,maxMessage="Ce champ doit contenir deux caractéres")
     */
    private $id;



    /**
     * @ORM\Column(name="fojLibelle",type="string",  nullable=true)
     * @Groups("formejuridique:read")
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     */
    private $fojLibelle;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="ninFormejuridique")
     */
    private $niNineapropositions;


    /**
     * @ORM\ManyToOne(targetEntity=NiFormeunite::class, inversedBy="regimeJuridique")
     * @Groups("formejuridique:read")
     */
    private $niFormeunite;

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="formeJuridique")
     */
    private $nINineas;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiNineaproposition::class, mappedBy="ninFormejuridique")
     */
    private $historyNiNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNINinea::class, mappedBy="formeJuridique")
     */
    private $historyNINineas;

    /**
     * @ORM\OneToMany(targetEntity=TempNINinea::class, mappedBy="formeJuridique")
     */
    private $tempNINineas;

    /**
     * @ORM\ManyToMany(targetEntity=NinTypedocuments::class, inversedBy="niFormejuridiques")
     */
    private $typeDocument;


    public function __construct()
    {
        $this->niNineapropositions = new ArrayCollection();
        $this->nINineas = new ArrayCollection();
        $this->historyNiNineapropositions = new ArrayCollection();
        $this->historyNINineas = new ArrayCollection();
        $this->tempNINineas = new ArrayCollection();
        $this->typeDocument = new ArrayCollection();
        
    }

    public function __toString()
    {
        return $this->fojLibelle;
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



    public function getFojLibelle(): ?string
    {
        return $this->fojLibelle;
    }

    public function setFojLibelle(?string $fojLibelle): self
    {
        $this->fojLibelle = $fojLibelle;

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
            $niNineaproposition->setNinFormejuridique($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getNinFormejuridique() === $this) {
                $niNineaproposition->setNinFormejuridique(null);
            }
        }

        return $this;
    }



    public function getNiFormeunite(): ?NiFormeunite
    {
        return $this->niFormeunite;
    }

    public function setNiFormeunite(?NiFormeunite $niFormeunite): self
    {
        $this->niFormeunite = $niFormeunite;

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
            $nINinea->setFormeJuridique($this);
        }

        return $this;
    }

    public function removeNINinea(NINinea $nINinea): self
    {
        if ($this->nINineas->removeElement($nINinea)) {
            // set the owning side to null (unless already changed)
            if ($nINinea->getFormeJuridique() === $this) {
                $nINinea->setFormeJuridique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiNineaproposition>
     */
    public function getHistoryNiNineapropositions(): Collection
    {
        return $this->historyNiNineapropositions;
    }

    public function addHistoryNiNineaproposition(HistoryNiNineaproposition $historyNiNineaproposition): self
    {
        if (!$this->historyNiNineapropositions->contains($historyNiNineaproposition)) {
            $this->historyNiNineapropositions[] = $historyNiNineaproposition;
            $historyNiNineaproposition->setNinFormejuridique($this);
        }

        return $this;
    }

    public function removeHistoryNiNineaproposition(HistoryNiNineaproposition $historyNiNineaproposition): self
    {
        if ($this->historyNiNineapropositions->removeElement($historyNiNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($historyNiNineaproposition->getNinFormejuridique() === $this) {
                $historyNiNineaproposition->setNinFormejuridique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNINinea>
     */
    public function getHistoryNINineas(): Collection
    {
        return $this->historyNINineas;
    }

    public function addHistoryNINinea(HistoryNINinea $historyNINinea): self
    {
        if (!$this->historyNINineas->contains($historyNINinea)) {
            $this->historyNINineas[] = $historyNINinea;
            $historyNINinea->setFormeJuridique($this);
        }

        return $this;
    }

    public function removeHistoryNINinea(HistoryNINinea $historyNINinea): self
    {
        if ($this->historyNINineas->removeElement($historyNINinea)) {
            // set the owning side to null (unless already changed)
            if ($historyNINinea->getFormeJuridique() === $this) {
                $historyNINinea->setFormeJuridique(null);
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
            $tempNINinea->setFormeJuridique($this);
        }

        return $this;
    }

    public function removeTempNINinea(TempNINinea $tempNINinea): self
    {
        if ($this->tempNINineas->removeElement($tempNINinea)) {
            // set the owning side to null (unless already changed)
            if ($tempNINinea->getFormeJuridique() === $this) {
                $tempNINinea->setFormeJuridique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NinTypedocuments>
     */
    public function getTypeDocument(): Collection
    {
        return $this->typeDocument;
    }

    public function addTypeDocument(NinTypedocuments $typeDocument): self
    {
        if (!$this->typeDocument->contains($typeDocument)) {
            $this->typeDocument[] = $typeDocument;
        }

        return $this;
    }

    public function removeTypeDocument(NinTypedocuments $typeDocument): self
    {
        $this->typeDocument->removeElement($typeDocument);

        return $this;
    }

   



}
