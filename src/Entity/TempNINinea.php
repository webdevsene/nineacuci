<?php

namespace App\Entity;

use App\Repository\TempNiNineaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TempNiNineaRepository::class)
 */
class TempNINinea
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    
    /**
     * @ORM\OneToMany(targetEntity=TempNiActivite::class, mappedBy="niNinea")
     */
    private $tempNiActivites;


    /**
     * @ORM\OneToMany(targetEntity=TempNiActiviteEconomique::class, mappedBy="niNinea")
     */
    private $tempNiActiviteEconomiques;


    
    /**
     * @ORM\OneToMany(targetEntity=TempNiCessation::class, mappedBy="ninea")
     */
    private $tempNiCessations;

    /**
     * @ORM\OneToMany(targetEntity=TempNiCoordonnees::class, mappedBy="ninNinea")
     */
    private $tempNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="niNinea")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="ninNinea")
     */
    private $tempNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNinproduits::class, mappedBy="nINinea")
     */
    private $tempNinproduits;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninRaison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninRegcom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninNumattrib;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninNinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninMisajour;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninSigle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninCreation;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninCuci;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatcre;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatreg;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninEmployninEmploy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninEnseigne;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninEtabsecond;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninEtat;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninMetier;

    /**
     * @ORM\ManyToOne(targetEntity=NiNatureLocaliteExploitation::class, inversedBy="tempNINineas")
     */
    private $ninNature;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninNetab;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninNineamere;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $ninNumetab;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninSiglemere;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninmajdate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ninmaj;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninNumerodemande;

    /**
     * @ORM\ManyToOne(targetEntity=NiAdministration::class, inversedBy="tempNINineas")
     */
    private $ninAdministration;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninCreationninea;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $formeUnite;

    /**
     * @ORM\ManyToOne(targetEntity=NiFormejuridique::class, inversedBy="tempNINineas")
     */
    private $formeJuridique;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNINineas")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tempNINineas")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niLibelleactiviteglobale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninTitrefoncier;

        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninAgrement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninArrete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninRecepisse;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $ninAccord;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninBordereau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninBail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninPermisoccuper;

    /**
     * @ORM\ManyToOne(targetEntity=NiStatut::class, inversedBy="tempNINineas")
     */
    private $ninStatut;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $observationsrccm;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=TempNiPersonne::class, inversedBy="tempNINineas")
     */
    private $niPersonne;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ninlock;



    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->tempNiActiviteEconomiques = new ArrayCollection();
        $this->tempNiCoordonnees = new ArrayCollection();
        $this->tempNiCessations = new ArrayCollection();
        $this->tempNiActivites = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
        $this->tempNinproduits = new ArrayCollection();

        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TempNiActiviteEconomique>
     */
    public function getTempNiActiviteEconomiques(): Collection
    {
        return $this->tempNiActiviteEconomiques;
    }

    public function addTempNiActiviteEconomique(TempNiActiviteEconomique $tempNiActiviteEconomique): self
    {
        if (!$this->tempNiActiviteEconomiques->contains($tempNiActiviteEconomique)) {
            $this->tempNiActiviteEconomiques[] = $tempNiActiviteEconomique;
            $tempNiActiviteEconomique->setNiNinea($this);
        }

        return $this;
    }

    public function removeTempNiActiviteEconomique(TempNiActiviteEconomique $tempNiActiviteEconomique): self
    {
        if ($this->tempNiActiviteEconomiques->removeElement($tempNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActiviteEconomique->getNiNinea() === $this) {
                $tempNiActiviteEconomique->setNiNinea(null);
            }
        }

        return $this;
    }


        /**
     * @return Collection<int, TempNiCoordonnees>
     */
    public function getTempNiCoordonnees(): Collection
    {
        return $this->tempNiCoordonnees;
    }

    public function addTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if (!$this->tempNiCoordonnees->contains($tempNiCoordonnee)) {
            $this->tempNiCoordonnees[] = $tempNiCoordonnee;
            $tempNiCoordonnee->setNinNinea($this);
        }

        return $this;
    }

    public function removeTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if ($this->tempNiCoordonnees->removeElement($tempNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCoordonnee->getNinNinea() === $this) {
                $tempNiCoordonnee->setNinNinea(null);
            }
        }

        return $this;
    }






    
    /**
     * @return Collection<int, TempNiCessation>
     */
    public function getTempNiCessations(): Collection
    {
        return $this->tempNiCessations;
    }

    public function addTempNiCessation(TempNiCessation $tempNiCessation): self
    {
        if (!$this->tempNiCessations->contains($tempNiCessation)) {
            $this->tempNiCessations[] = $tempNiCessation;
            $tempNiCessation->setNinea($this);
        }

        return $this;
    }

    public function removeTempNiCessation(TempNiCessation $tempNiCessation): self
    {
        if ($this->tempNiCessations->removeElement($tempNiCessation)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCessation->getNinea() === $this) {
                $tempNiCessation->setNinea(null);
            }
        }

        return $this;
    }



        /**
     * @return Collection<int, TempNiActivite>
     */
    public function getTempNiActivites(): Collection
    {
        return $this->tempNiActivites;
    }

    public function addTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if (!$this->tempNiActivites->contains($tempNiActivite)) {
            $this->tempNiActivites[] = $tempNiActivite;
            $tempNiActivite->setNiNinea($this);
        }

        return $this;
    }

    public function removeTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if ($this->tempNiActivites->removeElement($tempNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActivite->getNiNinea() === $this) {
                $tempNiActivite->setNiNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiDirigeant>
     */
    public function getTempNiDirigeants(): Collection
    {
        return $this->tempNiDirigeants;
    }

    public function addTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if (!$this->tempNiDirigeants->contains($tempNiDirigeant)) {
            $this->tempNiDirigeants[] = $tempNiDirigeant;
            $tempNiDirigeant->setNiNinea($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNiNinea() === $this) {
                $tempNiDirigeant->setNiNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNiPersonne>
     */
    public function getTempNiPersonnes(): Collection
    {
        return $this->tempNiPersonnes;
    }

    public function addTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if (!$this->tempNiPersonnes->contains($tempNiPersonne)) {
            $this->tempNiPersonnes[] = $tempNiPersonne;
            $tempNiPersonne->setNinNinea($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getNinNinea() === $this) {
                $tempNiPersonne->setNinNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNinproduits>
     */
    public function getTempNinproduits(): Collection
    {
        return $this->tempNinproduits;
    }

    public function addTempNinproduit(TempNinproduits $tempNinproduit): self
    {
        if (!$this->tempNinproduits->contains($tempNinproduit)) {
            $this->tempNinproduits[] = $tempNinproduit;
            $tempNinproduit->setNINinea($this);
        }

        return $this;
    }

    public function removeTempNinproduit(TempNinproduits $tempNinproduit): self
    {
        if ($this->tempNinproduits->removeElement($tempNinproduit)) {
            // set the owning side to null (unless already changed)
            if ($tempNinproduit->getNINinea() === $this) {
                $tempNinproduit->setNINinea(null);
            }
        }

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

    public function getNinRegcom(): ?string
    {
        return $this->ninRegcom;
    }

    public function setNinRegcom(?string $ninRegcom): self
    {
        $this->ninRegcom = $ninRegcom;

        return $this;
    }

    public function getNinNumattrib(): ?string
    {
        return $this->ninNumattrib;
    }

    public function setNinNumattrib(?string $ninNumattrib): self
    {
        $this->ninNumattrib = $ninNumattrib;

        return $this;
    }

    public function getNinNinea(): ?string
    {
        return $this->ninNinea;
    }

    public function setNinNinea(?string $ninNinea): self
    {
        $this->ninNinea = $ninNinea;

        return $this;
    }

    public function getNinMisajour(): ?\DateTimeInterface
    {
        return $this->ninMisajour;
    }

    public function setNinMisajour(?\DateTimeInterface $ninMisajour): self
    {
        $this->ninMisajour = $ninMisajour;

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

    public function getNinCreation(): ?\DateTimeInterface
    {
        return $this->ninCreation;
    }

    public function setNinCreation(?\DateTimeInterface $ninCreation): self
    {
        $this->ninCreation = $ninCreation;

        return $this;
    }

    public function getNinCuci(): ?string
    {
        return $this->ninCuci;
    }

    public function setNinCuci(?string $ninCuci): self
    {
        $this->ninCuci = $ninCuci;

        return $this;
    }

    public function getNinDatcre(): ?\DateTimeInterface
    {
        return $this->ninDatcre;
    }

    public function setNinDatcre(?\DateTimeInterface $ninDatcre): self
    {
        $this->ninDatcre = $ninDatcre;

        return $this;
    }

    public function getNinDatreg(): ?\DateTimeInterface
    {
        return $this->ninDatreg;
    }

    public function setNinDatreg(?\DateTimeInterface $ninDatreg): self
    {
        $this->ninDatreg = $ninDatreg;

        return $this;
    }

    public function getNinEmployninEmploy(): ?string
    {
        return $this->ninEmployninEmploy;
    }

    public function setNinEmployninEmploy(?string $ninEmployninEmploy): self
    {
        $this->ninEmployninEmploy = $ninEmployninEmploy;

        return $this;
    }

    public function getNinEnseigne(): ?string
    {
        return $this->ninEnseigne;
    }

    public function setNinEnseigne(?string $ninEnseigne): self
    {
        $this->ninEnseigne = $ninEnseigne;

        return $this;
    }

    public function getNinEtabsecond(): ?string
    {
        return $this->ninEtabsecond;
    }

    public function setNinEtabsecond(?string $ninEtabsecond): self
    {
        $this->ninEtabsecond = $ninEtabsecond;

        return $this;
    }

    public function getNinEtat(): ?string
    {
        return $this->ninEtat;
    }

    public function setNinEtat(?string $ninEtat): self
    {
        $this->ninEtat = $ninEtat;

        return $this;
    }

    public function getNinMetier(): ?string
    {
        return $this->ninMetier;
    }

    public function setNinMetier(?string $ninMetier): self
    {
        $this->ninMetier = $ninMetier;

        return $this;
    }

    public function getNinNature(): ?NiNatureLocaliteExploitation
    {
        return $this->ninNature;
    }

    public function setNinNature(?NiNatureLocaliteExploitation $ninNature): self
    {
        $this->ninNature = $ninNature;

        return $this;
    }

    public function getNinNetab(): ?string
    {
        return $this->ninNetab;
    }

    public function setNinNetab(?string $ninNetab): self
    {
        $this->ninNetab = $ninNetab;

        return $this;
    }

    public function getNinNineamere(): ?string
    {
        return $this->ninNineamere;
    }

    public function setNinNineamere(?string $ninNineamere): self
    {
        $this->ninNineamere = $ninNineamere;

        return $this;
    }

    public function getNinNumetab(): ?string
    {
        return $this->ninNumetab;
    }

    public function setNinNumetab(?string $ninNumetab): self
    {
        $this->ninNumetab = $ninNumetab;

        return $this;
    }

    public function getNinSiglemere(): ?string
    {
        return $this->ninSiglemere;
    }

    public function setNinSiglemere(?string $ninSiglemere): self
    {
        $this->ninSiglemere = $ninSiglemere;

        return $this;
    }

    public function getNinmajdate(): ?\DateTimeInterface
    {
        return $this->ninmajdate;
    }

    public function setNinmajdate(?\DateTimeInterface $ninmajdate): self
    {
        $this->ninmajdate = $ninmajdate;

        return $this;
    }

    public function getNinmaj(): ?int
    {
        return $this->ninmaj;
    }

    public function setNinmaj(?int $ninmaj): self
    {
        $this->ninmaj = $ninmaj;

        return $this;
    }

    public function getNinNumerodemande(): ?string
    {
        return $this->ninNumerodemande;
    }

    public function setNinNumerodemande(?string $ninNumerodemande): self
    {
        $this->ninNumerodemande = $ninNumerodemande;

        return $this;
    }

    public function getNinAdministration(): ?NiAdministration
    {
        return $this->ninAdministration;
    }

    public function setNinAdministration(?NiAdministration $ninAdministration): self
    {
        $this->ninAdministration = $ninAdministration;

        return $this;
    }

    public function getNinCreationninea(): ?\DateTimeInterface
    {
        return $this->ninCreationninea;
    }

    public function setNinCreationninea(?\DateTimeInterface $ninCreationninea): self
    {
        $this->ninCreationninea = $ninCreationninea;

        return $this;
    }

    public function getFormeUnite(): ?string
    {
        return $this->formeUnite;
    }

    public function setFormeUnite(?string $formeUnite): self
    {
        $this->formeUnite = $formeUnite;

        return $this;
    }

    public function getFormeJuridique(): ?NiFormejuridique
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?NiFormejuridique $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

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

    public function getNiLibelleactiviteglobale(): ?string
    {
        return $this->niLibelleactiviteglobale;
    }

    public function setNiLibelleactiviteglobale(?string $niLibelleactiviteglobale): self
    {
        $this->niLibelleactiviteglobale = $niLibelleactiviteglobale;

        return $this;
    }

    public function getNinTitrefoncier(): ?string
    {
        return $this->ninTitrefoncier;
    }

    public function setNinTitrefoncier(?string $ninTitrefoncier): self
    {
        $this->ninTitrefoncier = $ninTitrefoncier;

        return $this;
    }

    public function getNinStatut(): ?NiStatut
    {
        return $this->ninStatut;
    }

    public function setNinStatut(?NiStatut $ninStatut): self
    {
        $this->ninStatut = $ninStatut;

        return $this;
    }

    public function getNinAgrement(): ?string
    {
        return $this->ninAgrement;
    }

    public function setNinAgrement(?string $ninAgrement): self
    {
        $this->ninAgrement = $ninAgrement;

        return $this;
    }

    public function getNinArrete(): ?string
    {
        return $this->ninArrete;
    }

    public function setNinArrete(?string $ninArrete): self
    {
        $this->ninArrete = $ninArrete;

        return $this;
    }

    public function getNinRecepisse(): ?string
    {
        return $this->ninRecepisse;
    }

    public function setNinRecepisse(?string $ninRecepisse): self
    {
        $this->ninRecepisse = $ninRecepisse;

        return $this;
    }

    public function getNinAccord(): ?string
    {
        return $this->ninAccord;
    }

    public function setNinAccord(?string $ninAccord): self
    {
        $this->ninAccord = $ninAccord;

        return $this;
    }

    public function getNinBordereau(): ?string
    {
        return $this->ninBordereau;
    }

    public function setNinBordereau(?string $ninBordereau): self
    {
        $this->ninBordereau = $ninBordereau;

        return $this;
    }

    public function getNinBail(): ?string
    {
        return $this->ninBail;
    }

    public function setNinBail(?string $ninBail): self
    {
        $this->ninBail = $ninBail;

        return $this;
    }

    public function getNinPermisoccuper(): ?string
    {
        return $this->ninPermisoccuper;
    }

    public function setNinPermisoccuper(?string $ninPermisoccuper): self
    {
        $this->ninPermisoccuper = $ninPermisoccuper;

        return $this;
    }

    public function getObservationsrccm(): ?string
    {
        return $this->observationsrccm;
    }

    public function setObservationsrccm(?string $observationsrccm): self
    {
        $this->observationsrccm = $observationsrccm;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getNiPersonne(): ?TempNiPersonne
    {
        return $this->niPersonne;
    }

    public function setNiPersonne(?TempNiPersonne $niPersonne): self
    {
        $this->niPersonne = $niPersonne;

        return $this;
    }

    public function isNinlock(): ?bool
    {
        return $this->ninlock;
    }

    public function setNinlock(?bool $ninlock): self
    {
        $this->ninlock = $ninlock;

        return $this;
    }



}