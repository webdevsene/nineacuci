<?php

namespace App\Entity;

use App\Repository\HistoryNINineaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryNINineaRepository::class)
 */
class HistoryNINinea
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\ManyToOne(targetEntity=HistoryNiPersonne::class, inversedBy="ninNinea")
     */
    private $historyNiPersonne;


    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActivite::class, mappedBy="niNinea")
     */
    private $historyNiActivites;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActiviteEconomique::class, mappedBy="niNinea")
     */
    private $historyNiActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiCoordonnees::class, mappedBy="ninNinea")
     */
    private $historyNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="niNinea")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNinproduits::class, mappedBy="niNinea")
     */
    private $historyNinproduits;

    /**
     * @ORM\ManyToOne(targetEntity=NiNatureLocaliteExploitation::class, inversedBy="historyNINineas")
     */
    private $ninNature;

    /**
     * @ORM\ManyToOne(targetEntity=NiAdministration::class, inversedBy="historyNINineas")
     */
    private $ninAdministration;

    /**
     * @ORM\ManyToOne(targetEntity=NiFormejuridique::class, inversedBy="historyNINineas")
     */
    private $formeJuridique;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historyNINineas")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historyNINineas")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninRaison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninRegcom;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $ninStatut;

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
    private $ninEmploy;

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninCreationninea;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $formeUnite;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=HistoryDocumentCreation::class, mappedBy="documentNinea")
     */
    private $historyDocumentCreations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomCommercial;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDateDocument;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninNumeroDocument;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninRegcomReprise;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatregReprise;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatregModif;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ninRegcomModif;

    /**
     * @ORM\ManyToOne(targetEntity=NinTypedocuments::class, inversedBy="historyNINineas")
     */
    private $niTypedocument;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observationsrccm;

    /**
     * @ORM\ManyToOne(targetEntity=NiStatut::class, inversedBy="historyNINineas")
     */
    private $ninStatutH;

    public function __construct()
    {
        $this->historyNiActivites = new ArrayCollection();
        $this->historyNiActiviteEconomiques = new ArrayCollection();
        $this->historyNiCoordonnees = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNinproduits = new ArrayCollection();
        $this->historyDocumentCreations = new ArrayCollection();

    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHistoryNiPersonne(): ?HistoryNiPersonne
    {
        return $this->historyNiPersonne;
    }

    public function setHistoryNiPersonne(?HistoryNiPersonne $historyNiPersonne): self
    {
        $this->historyNiPersonne = $historyNiPersonne;

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiActivite>
     */
    public function getHistoryNiActivites(): Collection
    {
        return $this->historyNiActivites;
    }

    public function addHistoryNiActivite(HistoryNiActivite $historyNiActivite): self
    {
        if (!$this->historyNiActivites->contains($historyNiActivite)) {
            $this->historyNiActivites[] = $historyNiActivite;
            $historyNiActivite->setNiNinea($this);
        }

        return $this;
    }

    public function removeHistoryNiActivite(HistoryNiActivite $historyNiActivite): self
    {
        if ($this->historyNiActivites->removeElement($historyNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActivite->getNiNinea() === $this) {
                $historyNiActivite->setNiNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiActiviteEconomique>
     */
    public function getHistoryNiActiviteEconomiques(): Collection
    {
        return $this->historyNiActiviteEconomiques;
    }

    public function addHistoryNiActiviteEconomique(HistoryNiActiviteEconomique $historyNiActiviteEconomique): self
    {
        if (!$this->historyNiActiviteEconomiques->contains($historyNiActiviteEconomique)) {
            $this->historyNiActiviteEconomiques[] = $historyNiActiviteEconomique;
            $historyNiActiviteEconomique->setNiNinea($this);
        }

        return $this;
    }

    public function removeHistoryNiActiviteEconomique(HistoryNiActiviteEconomique $historyNiActiviteEconomique): self
    {
        if ($this->historyNiActiviteEconomiques->removeElement($historyNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActiviteEconomique->getNiNinea() === $this) {
                $historyNiActiviteEconomique->setNiNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiCoordonnees>
     */
    public function getHistoryNiCoordonnees(): Collection
    {
        return $this->historyNiCoordonnees;
    }

    public function addHistoryNiCoordonnee(HistoryNiCoordonnees $historyNiCoordonnee): self
    {
        if (!$this->historyNiCoordonnees->contains($historyNiCoordonnee)) {
            $this->historyNiCoordonnees[] = $historyNiCoordonnee;
            $historyNiCoordonnee->setNinNinea($this);
        }

        return $this;
    }

    public function removeHistoryNiCoordonnee(HistoryNiCoordonnees $historyNiCoordonnee): self
    {
        if ($this->historyNiCoordonnees->removeElement($historyNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($historyNiCoordonnee->getNinNinea() === $this) {
                $historyNiCoordonnee->setNinNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiDirigeant>
     */
    public function getHistoryNiDirigeants(): Collection
    {
        return $this->historyNiDirigeants;
    }

    public function addHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if (!$this->historyNiDirigeants->contains($historyNiDirigeant)) {
            $this->historyNiDirigeants[] = $historyNiDirigeant;
            $historyNiDirigeant->setNiNinea($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNiNinea() === $this) {
                $historyNiDirigeant->setNiNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNinproduits>
     */
    public function getHistoryNinproduits(): Collection
    {
        return $this->historyNinproduits;
    }

    public function addHistoryNinproduit(HistoryNinproduits $historyNinproduit): self
    {
        if (!$this->historyNinproduits->contains($historyNinproduit)) {
            $this->historyNinproduits[] = $historyNinproduit;
            $historyNinproduit->setNiNinea($this);
        }

        return $this;
    }

    public function removeHistoryNinproduit(HistoryNinproduits $historyNinproduit): self
    {
        if ($this->historyNinproduits->removeElement($historyNinproduit)) {
            // set the owning side to null (unless already changed)
            if ($historyNinproduit->getNiNinea() === $this) {
                $historyNinproduit->setNiNinea(null);
            }
        }

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

    public function getNinAdministration(): ?NiAdministration
    {
        return $this->ninAdministration;
    }

    public function setNinAdministration(?NiAdministration $ninAdministration): self
    {
        $this->ninAdministration = $ninAdministration;

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

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

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

    public function getNinStatut(): ?string
    {
        return $this->ninStatut;
    }

    public function setNinStatut(?string $ninStatut): self
    {
        $this->ninStatut = $ninStatut;

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

    public function getNinEmploy(): ?string
    {
        return $this->ninEmploy;
    }

    public function setNinEmploy(?string $ninEmploy): self
    {
        $this->ninEmploy = $ninEmploy;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, HistoryDocumentCreation>
     */
    public function getHistoryDocumentCreations(): Collection
    {
        return $this->historyDocumentCreations;
    }

    public function addHistoryDocumentCreation(HistoryDocumentCreation $historyDocumentCreation): self
    {
        if (!$this->historyDocumentCreations->contains($historyDocumentCreation)) {
            $this->historyDocumentCreations[] = $historyDocumentCreation;
            $historyDocumentCreation->setDocumentNinea($this);
        }

        return $this;
    }

    public function removeHistoryDocumentCreation(HistoryDocumentCreation $historyDocumentCreation): self
    {
        if ($this->historyDocumentCreations->removeElement($historyDocumentCreation)) {
            // set the owning side to null (unless already changed)
            if ($historyDocumentCreation->getDocumentNinea() === $this) {
                $historyDocumentCreation->setDocumentNinea(null);
            }
        }

        return $this;
    }

    public function getNomCommercial(): ?string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(?string $nomCommercial): self
    {
        $this->nomCommercial = $nomCommercial;

        return $this;
    }

    public function getNinDateDocument(): ?\DateTimeInterface
    {
        return $this->ninDateDocument;
    }

    public function setNinDateDocument(?\DateTimeInterface $ninDateDocument): self
    {
        $this->ninDateDocument = $ninDateDocument;

        return $this;
    }

    public function getNinNumeroDocument(): ?string
    {
        return $this->ninNumeroDocument;
    }

    public function setNinNumeroDocument(?string $ninNumeroDocument): self
    {
        $this->ninNumeroDocument = $ninNumeroDocument;

        return $this;
    }

    public function getNinRegcomReprise(): ?string
    {
        return $this->ninRegcomReprise;
    }

    public function setNinRegcomReprise(?string $ninRegcomReprise): self
    {
        $this->ninRegcomReprise = $ninRegcomReprise;

        return $this;
    }

    public function getNinDatregReprise(): ?\DateTimeInterface
    {
        return $this->ninDatregReprise;
    }

    public function setNinDatregReprise(?\DateTimeInterface $ninDatregReprise): self
    {
        $this->ninDatregReprise = $ninDatregReprise;

        return $this;
    }

    public function getNinDatregModif(): ?\DateTimeInterface
    {
        return $this->ninDatregModif;
    }

    public function setNinDatregModif(?\DateTimeInterface $ninDatregModif): self
    {
        $this->ninDatregModif = $ninDatregModif;

        return $this;
    }

    public function getNinRegcomModif(): ?string
    {
        return $this->ninRegcomModif;
    }

    public function setNinRegcomModif(?string $ninRegcomModif): self
    {
        $this->ninRegcomModif = $ninRegcomModif;

        return $this;
    }

    public function getNiTypedocument(): ?NinTypedocuments
    {
        return $this->niTypedocument;
    }

    public function setNiTypedocument(?NinTypedocuments $niTypedocument): self
    {
        $this->niTypedocument = $niTypedocument;

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

    public function getNinStatutH(): ?NiStatut
    {
        return $this->ninStatutH;
    }

    public function setNinStatutH(?NiStatut $ninStatutH): self
    {
        $this->ninStatutH = $ninStatutH;

        return $this;
    }

}
