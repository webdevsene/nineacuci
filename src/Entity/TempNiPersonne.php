<?php

namespace App\Entity;

use App\Repository\TempNiPersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiPersonneRepository::class)
 */
class TempNiPersonne
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
    private $ninNom;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninPrenom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninLieuNaissance;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninCNI;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDateCNI;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninSigle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ninRaison;

    /**
     * @ORM\ManyToOne(targetEntity=NiSexe::class, inversedBy="tempNiPersonnes")
     */
    private $ninSexe;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=NiCivilite::class, inversedBy="tempNiPersonnes")
     */
    private $civilite;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="tempNiPersonnes")
     */
    private $nationalite;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNiPersonnes")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="tempNiPersonnes")
     */
    private $ninQvh;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninTelephone;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninEmailPersonnel;

    /**
     * @ORM\ManyToOne(targetEntity=NiTypevoie::class, inversedBy="tempNiPersonnes")
     */
    private $ninTypevoie;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ninVoie;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $numVoie;

    /**
     * @ORM\ManyToOne(targetEntity=TempNINinea::class, inversedBy="tempNiPersonnes")
     */
    private $ninNinea;

    /**
     * @ORM\ManyToOne(targetEntity=TempNiNineaproposition::class, inversedBy="tempNiPersonnes")
     */
    private $niNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=TempNINinea::class, mappedBy="niPersonne")
     */
    private $tempNINineas;

    public function __construct()
    {
        $this->tempNINineas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinNom(): ?string
    {
        return $this->ninNom;
    }

    public function setNinNom(?string $ninNom): self
    {
        $this->ninNom = $ninNom;

        return $this;
    }

    public function getNinPrenom(): ?string
    {
        return $this->ninPrenom;
    }

    public function setNinPrenom(?string $ninPrenom): self
    {
        $this->ninPrenom = $ninPrenom;

        return $this;
    }

    public function getNinDateNaissance(): ?\DateTimeInterface
    {
        return $this->ninDateNaissance;
    }

    public function setNinDateNaissance(?\DateTimeInterface $ninDateNaissance): self
    {
        $this->ninDateNaissance = $ninDateNaissance;

        return $this;
    }

    public function getNinLieuNaissance(): ?string
    {
        return $this->ninLieuNaissance;
    }

    public function setNinLieuNaissance(?string $ninLieuNaissance): self
    {
        $this->ninLieuNaissance = $ninLieuNaissance;

        return $this;
    }

    public function getNinCNI(): ?string
    {
        return $this->ninCNI;
    }

    public function setNinCNI(?string $ninCNI): self
    {
        $this->ninCNI = $ninCNI;

        return $this;
    }

    public function getNinDateCNI(): ?\DateTimeInterface
    {
        return $this->ninDateCNI;
    }

    public function setNinDateCNI(?\DateTimeInterface $ninDateCNI): self
    {
        $this->ninDateCNI = $ninDateCNI;

        return $this;
    }

    public function getNinSigle(): ?string
    {
        return $this->ninSigle;
    }

    public function setNinSigle(?string $ninSigle): self
    {
        $this->ninSigle = $ninSigle;

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

    public function getNinRaison(): ?string
    {
        return $this->ninRaison;
    }

    public function setNinRaison(?string $ninRaison): self
    {
        $this->ninRaison = $ninRaison;

        return $this;
    }

    public function getNinSexe(): ?NiSexe
    {
        return $this->ninSexe;
    }

    public function setNinSexe(?NiSexe $ninSexe): self
    {
        $this->ninSexe = $ninSexe;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCivilite(): ?NiCivilite
    {
        return $this->civilite;
    }

    public function setCivilite(?NiCivilite $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getNationalite(): ?Pays
    {
        return $this->nationalite;
    }

    public function setNationalite(?Pays $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getNinQvh(): ?QVH
    {
        return $this->ninQvh;
    }

    public function setNinQvh(?QVH $ninQvh): self
    {
        $this->ninQvh = $ninQvh;

        return $this;
    }

    public function getNinTelephone(): ?string
    {
        return $this->ninTelephone;
    }

    public function setNinTelephone(?string $ninTelephone): self
    {
        $this->ninTelephone = $ninTelephone;

        return $this;
    }

    public function getNinEmailPersonnel(): ?string
    {
        return $this->ninEmailPersonnel;
    }

    public function setNinEmailPersonnel(?string $ninEmailPersonnel): self
    {
        $this->ninEmailPersonnel = $ninEmailPersonnel;

        return $this;
    }

    public function getNinTypevoie(): ?NiTypevoie
    {
        return $this->ninTypevoie;
    }

    public function setNinTypevoie(?NiTypevoie $ninTypevoie): self
    {
        $this->ninTypevoie = $ninTypevoie;

        return $this;
    }

    public function getNinVoie(): ?string
    {
        return $this->ninVoie;
    }

    public function setNinVoie(?string $ninVoie): self
    {
        $this->ninVoie = $ninVoie;

        return $this;
    }

    public function getNumVoie(): ?string
    {
        return $this->numVoie;
    }

    public function setNumVoie(?string $numVoie): self
    {
        $this->numVoie = $numVoie;

        return $this;
    }

    public function getNinNinea(): ?TempNINinea
    {
        return $this->ninNinea;
    }

    public function setNinNinea(?TempNINinea $ninNinea): self
    {
        $this->ninNinea = $ninNinea;

        return $this;
    }

    public function getNiNineapropositions(): ?TempNiNineaproposition
    {
        return $this->niNineapropositions;
    }

    public function setNiNineapropositions(?TempNiNineaproposition $niNineapropositions): self
    {
        $this->niNineapropositions = $niNineapropositions;

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
            $tempNINinea->setNiPersonne($this);
        }

        return $this;
    }

    public function removeTempNINinea(TempNINinea $tempNINinea): self
    {
        if ($this->tempNINineas->removeElement($tempNINinea)) {
            // set the owning side to null (unless already changed)
            if ($tempNINinea->getNiPersonne() === $this) {
                $tempNINinea->setNiPersonne(null);
            }
        }

        return $this;
    }
}
