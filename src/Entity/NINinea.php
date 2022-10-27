<?php

namespace App\Entity;

use App\Repository\NINineaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NINineaRepository::class)
 *   @ORM\Table(name="`ni_ninea`")
 */
class NINinea
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
     * @ORM\ManyToOne(targetEntity=NiNatureLocaliteExploitation::class, inversedBy="nINineas")
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
     * @ORM\ManyToOne(targetEntity=NiAdministration::class, inversedBy="nINineas")
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
     * @ORM\ManyToOne(targetEntity=NiFormejuridique::class, inversedBy="nINineas")
     */
    private $formeJuridique;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="nINineas")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="nINineaModifiedBy")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=NiCoordonnees::class,fetch="EAGER",orphanRemoval=true,cascade={"persist","remove"}, mappedBy="ninNinea")
     */
    private $niCoordonnees;


    /**
     * @ORM\OneToMany(targetEntity=NiActivite::class,fetch="EAGER",orphanRemoval=true,cascade={"persist","remove"}, mappedBy="nINinea")
     */
    private $ninActivite;

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class,fetch="EAGER",orphanRemoval=true,cascade={"persist","remove"}, mappedBy="nINinea")
     */
    private $ninDirigeant;
   

    /**
     * @ORM\OneToMany(targetEntity=NiActiviteEconomique::class,fetch="EAGER",orphanRemoval=true,cascade={"persist","remove"}, mappedBy="nINinea")
     */
    private $ninActivitesEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=Ninproduits::class,fetch="EAGER",orphanRemoval=true,cascade={"persist","remove"}, mappedBy="nINinea")
     */
    private $ninproduits;

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
     * @ORM\ManyToOne(targetEntity=NiPersonne::class, inversedBy="ninNinea")
     */
    private $niPersonne;

    /**
     * @ORM\OneToMany(targetEntity=NiCessation::class, mappedBy="ninea")
     */
    private $niCessations;

    /**
     * @ORM\OneToMany(targetEntity=Nireactivation::class, mappedBy="ninea")
     */
    private $nireactivations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;
    
     /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $observationsrccm;

    /**
     * @ORM\ManyToOne(targetEntity=NiStatut::class, inversedBy="nINineas")
     */
    private $ninStatut;

    /**
     * @ORM\ManyToOne(targetEntity=NinTypedocuments::class, inversedBy="nINineas")
     */
    private $niTypedocument;



    public function __construct()
    {
        $this->ninCreation=new \DateTime();
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->niCoordonnees = new ArrayCollection();
        $this->ninActivite = new ArrayCollection();
        $this->ninDirigeant = new ArrayCollection();
        $this->ninActivitesEconomiques = new ArrayCollection();
        $this->ninproduits = new ArrayCollection();
        $this->niCessations = new ArrayCollection();
        $this->nireactivations = new ArrayCollection();

    }

    public function __toString()
    {
        return $this->ninNinea;
    }


    public function getId(): ?int
    {
        return $this->id;
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


    public function setNinCodop(?string $ninCodop): self
    {
        $this->ninCodop = $ninCodop;

        return $this;
    }

    public function getNinCompid(): ?string
    {
        return $this->ninCompid;
    }

    public function setNinCompid(?string $ninCompid): self
    {
        $this->ninCompid = $ninCompid;

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

    public function getNinDatnais(): ?\DateTimeInterface
    {
        return $this->ninDatnais;
    }

    public function setNinDatnais(?\DateTimeInterface $ninDatnais): self
    {
        $this->ninDatnais = $ninDatnais;

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

    public function getNinForme(): ?string
    {
        return $this->ninForme;
    }

    public function setNinForme(?string $ninForme): self
    {
        $this->ninForme = $ninForme;

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

    public function getNinNatures(): ?string
    {
        return $this->ninNatures;
    }

    public function setNinNatures(?string $ninNatures): self
    {
        $this->ninNatures = $ninNatures;

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

    public function getNinNiden(): ?string
    {
        return $this->ninNiden;
    }

    public function setNinNiden(?string $ninNiden): self
    {
        $this->ninNiden = $ninNiden;

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

    public function getNinNumimpot(): ?string
    {
        return $this->ninNumimpot;
    }

    public function setNinNumimpot(?string $ninNumimpot): self
    {
        $this->ninNumimpot = $ninNumimpot;

        return $this;
    }

    public function getNinNumipres(): ?string
    {
        return $this->ninNumipres;
    }

    public function setNinNumipres(?string $ninNumipres): self
    {
        $this->ninNumipres = $ninNumipres;

        return $this;
    }


    public function getNinOrigine(): ?string
    {
        return $this->ninOrigine;
    }

    public function setNinOrigine(?string $ninOrigine): self
    {
        $this->ninOrigine = $ninOrigine;

        return $this;
    }


    public function getNinAutorisation(): ?string
    {
        return $this->ninAutorisation;
    }

    public function setNinAutorisation(?string $ninAutorisation): self
    {
        $this->ninAutorisation = $ninAutorisation;

        return $this;
    }

    public function getNinNineacss(): ?string
    {
        return $this->ninNineacss;
    }

    public function setNinNineacss(?string $ninNineacss): self
    {
        $this->ninNineacss = $ninNineacss;

        return $this;
    }

    public function getNinNineaipres(): ?string
    {
        return $this->ninNineaipres;
    }

    public function setNinNineaipres(?string $ninNineaipres): self
    {
        $this->ninNineaipres = $ninNineaipres;

        return $this;
    }

    public function getNinNineadgd(): ?string
    {
        return $this->ninNineadgd;
    }

    public function setNinNineadgd(?string $ninNineadgd): self
    {
        $this->ninNineadgd = $ninNineadgd;

        return $this;
    }

    public function getNinagencecss(): ?string
    {
        return $this->ninagencecss;
    }

    public function setNinagencecss(?string $ninagencecss): self
    {
        $this->ninagencecss = $ninagencecss;

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

    public function getNinconsolidedate(): ?\DateTimeInterface
    {
        return $this->ninconsolidedate;
    }

    public function setNinconsolidedate(?\DateTimeInterface $ninconsolidedate): self
    {
        $this->ninconsolidedate = $ninconsolidedate;

        return $this;
    }

    public function getNincni(): ?string
    {
        return $this->nincni;
    }

    public function setNincni(?string $nincni): self
    {
        $this->nincni = $nincni;

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

    public function getNinNom(): ?string
    {
        return $this->ninNom;
    }

    public function setNinNom(?string $ninNom): self
    {
        $this->ninNom = $ninNom;

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

    public function getNiEstnouveau(): ?string
    {
        return $this->niEstnouveau;
    }

    public function setNiEstnouveau(?string $niEstnouveau): self
    {
        $this->niEstnouveau = $niEstnouveau;

        return $this;
    }

    public function getNinTransmis(): ?string
    {
        return $this->ninTransmis;
    }

    public function setNinTransmis(?string $ninTransmis): self
    {
        $this->ninTransmis = $ninTransmis;

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

    public function getNinValidercofi(): ?string
    {
        return $this->ninValidercofi;
    }

    public function setNinValidercofi(?string $ninValidercofi): self
    {
        $this->ninValidercofi = $ninValidercofi;

        return $this;
    }

    public function getNinNomPresidentGiesociiete(): ?string
    {
        return $this->ninNomPresidentGiesociiete;
    }

    public function setNinNomPresidentGiesociiete(?string $ninNomPresidentGiesociiete): self
    {
        $this->ninNomPresidentGiesociiete = $ninNomPresidentGiesociiete;

        return $this;
    }

    public function getNinUserencours(): ?string
    {
        return $this->ninUserencours;
    }

    public function setNinUserencours(?string $ninUserencours): self
    {
        $this->ninUserencours = $ninUserencours;

        return $this;
    }

    public function getNinDatecni(): ?\DateTimeInterface
    {
        return $this->ninDatecni;
    }

    public function setNinDatecni(?\DateTimeInterface $ninDatecni): self
    {
        $this->ninDatecni = $ninDatecni;

        return $this;
    }

    public function getNinDatesuspension(): ?\DateTimeInterface
    {
        return $this->ninDatesuspension;
    }

    public function setNinDatesuspension(?\DateTimeInterface $ninDatesuspension): self
    {
        $this->ninDatesuspension = $ninDatesuspension;

        return $this;
    }

    public function getNindatereprise(): ?\DateTimeInterface
    {
        return $this->nindatereprise;
    }

    public function setNindatereprise(?\DateTimeInterface $nindatereprise): self
    {
        $this->nindatereprise = $nindatereprise;

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


      /**
     * @return Collection<int, NiCoordonnees>
     */
    public function getNiCoordonnees(): Collection
    {
        return $this->niCoordonnees;
    }

    public function addNiCoordonnee(NiCoordonnees $niCoordonnee): self
    {
        if (!$this->niCoordonnees->contains($niCoordonnee)) {
            $this->niCoordonnees[] = $niCoordonnee;
            $niCoordonnee->setNinNinea($this);
        }

        return $this;
    }

    public function removeNiCoordonnee(NiCoordonnees $niCoordonnee): self
    {
        if ($this->niCoordonnees->removeElement($niCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($niCoordonnee->getNinNinea() === $this) {
                $niCoordonnee->setNinNinea(null);
            }
        }

        return $this;
    }

  
    /**
     * @return Collection<int, NiActivite>
     */
    public function getNinActivite(): Collection
    {
        return $this->ninActivite;
    }

    public function addNinActivite(NiActivite $ninActivite): self
    {
        if (!$this->ninActivite->contains($ninActivite)) {
            $this->ninActivite[] = $ninActivite;
            $ninActivite->setNINinea($this);
        }

        return $this;
    }

    public function removeNinActivite(NiActivite $ninActivite): self
    {
        if ($this->ninActivite->removeElement($ninActivite)) {
            // set the owning side to null (unless already changed)
            if ($ninActivite->getNINinea() === $this) {
                $ninActivite->setNINinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiDirigeant>
     */
    public function getNinDirigeant(): Collection
    {
        return $this->ninDirigeant;
    }

    public function addNinDirigeant(NiDirigeant $ninDirigeant): self
    {
        if (!$this->ninDirigeant->contains($ninDirigeant)) {
            $this->ninDirigeant[] = $ninDirigeant;
            $ninDirigeant->setNINinea($this);
        }

        return $this;
    }

    public function removeNinDirigeant(NiDirigeant $ninDirigeant): self
    {
        if ($this->ninDirigeant->removeElement($ninDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($ninDirigeant->getNINinea() === $this) {
                $ninDirigeant->setNINinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiActiviteEconomique>
     */
    public function getNinActivitesEconomiques(): Collection
    {
        return $this->ninActivitesEconomiques;
    }

    public function addNinActivitesEconomique(NiActiviteEconomique $ninActivitesEconomique): self
    {
        if (!$this->ninActivitesEconomiques->contains($ninActivitesEconomique)) {
            $this->ninActivitesEconomiques[] = $ninActivitesEconomique;
            $ninActivitesEconomique->setNINinea($this);
        }

        return $this;
    }

    public function removeNinActivitesEconomique(NiActiviteEconomique $ninActivitesEconomique): self
    {
        if ($this->ninActivitesEconomiques->removeElement($ninActivitesEconomique)) {
            // set the owning side to null (unless already changed)
            if ($ninActivitesEconomique->getNINinea() === $this) {
                $ninActivitesEconomique->setNINinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ninproduits>
     */
    public function getNinproduits(): Collection
    {
        return $this->ninproduits;
    }

    public function addNinproduit(Ninproduits $ninproduit): self
    {
        if (!$this->ninproduits->contains($ninproduit)) {
            $this->ninproduits[] = $ninproduit;
            $ninproduit->setNINinea($this);
        }

        return $this;
    }

    public function removeNinproduit(Ninproduits $ninproduit): self
    {
        if ($this->ninproduits->removeElement($ninproduit)) {
            // set the owning side to null (unless already changed)
            if ($ninproduit->getNINinea() === $this) {
                $ninproduit->setNINinea(null);
            }
        }

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

    public function setNinAccord(string $ninAccord): self
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

    public function getNiPersonne(): ?NiPersonne
    {
        return $this->niPersonne;
    }

    public function setNiPersonne(?NiPersonne $niPersonne): self
    {
        $this->niPersonne = $niPersonne;

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
            $niCessation->setNinea($this);
        }

        return $this;
    }

    public function removeNiCessation(NiCessation $niCessation): self
    {
        if ($this->niCessations->removeElement($niCessation)) {
            // set the owning side to null (unless already changed)
            if ($niCessation->getNinea() === $this) {
                $niCessation->setNinea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Nireactivation>
     */
    public function getNireactivations(): Collection
    {
        return $this->nireactivations;
    }

    public function addNireactivation(Nireactivation $nireactivation): self
    {
        if (!$this->nireactivations->contains($nireactivation)) {
            $this->nireactivations[] = $nireactivation;
            $nireactivation->setNinea($this);
        }

        return $this;
    }

    public function removeNireactivation(Nireactivation $nireactivation): self
    {
        if ($this->nireactivations->removeElement($nireactivation)) {
            // set the owning side to null (unless already changed)
            if ($nireactivation->getNinea() === $this) {
                $nireactivation->setNinea(null);
            }
        }

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

    public function getObservationsrccm(): ?string
    {
        return $this->observationsrccm;
    }

    public function setObservationsrccm(?string $observationsrccm): self
    {
        $this->observationsrccm = $observationsrccm;

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

    public function getNiTypedocument(): ?NinTypedocuments
    {
        return $this->niTypedocument;
    }

    public function setNiTypedocument(?NinTypedocuments $niTypedocument): self
    {
        $this->niTypedocument = $niTypedocument;

        return $this;
    }

}
