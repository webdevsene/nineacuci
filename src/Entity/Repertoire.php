<?php

namespace App\Entity;

use App\Repository\RepertoireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=RepertoireRepository::class)
 */
class Repertoire
{
   

     /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="repertoires")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="repertoireUpdatedBy")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="L'activité principale  ne peut etre vide.")
     */
    private $activitePrincipale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addresseDuCabinet;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $anneeDeCreation;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $anneeDeFusion;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $boitePostale;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     *  @Assert\NotBlank(message="Le numéro de CUCI ne peut etre vide.")
     */
    private $codeCuci;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codeImportateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commune;

     /**
     * @ORM\ManyToOne(targetEntity=Control::class, inversedBy="repertoires")
     */
    private $controle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateArreteEffectif;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateCessation;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $clotureDeExercice;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $clotureExercicePrecedent;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $debutExerciceComptable;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $finExerciceComptable;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateMiseAjour;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateReception;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateReactivation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="La dénomination sociale ne peut etre vide.")
     */
    private $denominationSocial;

    
    public $departement;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $dureeDeExercice;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $dureeExercicePrecedent;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $etablissementsDansPays;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $etablissementsHorsPays;

    /**
     * @ORM\ManyToOne(targetEntity=Qualite::class, inversedBy="repertoires")
     */
    private $fonctionDucontact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le ninea ne peut etre vide.")
     */
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NomDuCabinet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroCaisseSociale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\NotBlank(message="Le numéro de registre de commerce ne peut etre vide.")
     */
    private $numeroRegistreCommerce;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $numeroTelecopie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="repertoires")
     */
    private $paysDuEntreprise;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $premiereAnneeExercice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raisonCessation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raisonReactivation;


   

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $sigle;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $statut;

    
    /**
     * @ORM\ManyToOne(targetEntity=SYSCOA::class, inversedBy="repertoires")
     * 
     */
    private $syscoa;

    

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le téléphone1  ne peut etre vide.")
     */
    private $telephone1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $telephone2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephoneDuCabinet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autreFormeJuridique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $enseigne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reactivation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cacr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cav;

   

   

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploadedFileName;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $anneeDeReception;

    /**
     * @ORM\ManyToOne(targetEntity=TypeNINEA::class, inversedBy="repertoires")
     */
    private $typeNINEA;

    /**
     * @ORM\OneToMany(targetEntity=Activities::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="repertoire")
     */
    private $activities;

   

    /**
     * @ORM\ManyToOne(targetEntity=NAEMA::class, inversedBy="repertoires")
     * 
     */
    private $naema;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMAS::class, inversedBy="repertoires")
     *
     */
    private $naemas;

    /**
     *@ORM\ManyToOne(targetEntity=Citi::class, inversedBy="repertoires")
     * 
     */
    private $citi;

    /**
     * @ORM\Column(type="string", length=123, nullable=true)
     */
    private $NomDuContact;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prenomDuContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $addresseDuContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fonctionDuContact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="L' addresse  ne peut etre vide.")
     */
    private $addresseComplete;



    /**
     * @ORM\OneToMany(targetEntity=CommissairesComptes::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="repertoire")
     */
    private $commissairesComptes;

    /**
     * @ORM\OneToMany(targetEntity=Dirigeant::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="repertoire")
     */
    private $dirigeants;

    /**
     * @ORM\OneToMany(targetEntity=Actionnaire::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"},mappedBy="repertoire")
     */
    private $actionnaires;

    /**
     * @ORM\OneToMany(targetEntity=MembreConseil::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="repertoire")
     */
    private $membreConseils;

    /**
     * @ORM\OneToMany(targetEntity=Filiales::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"},mappedBy="repertoire")
     */
    private $filiales;

    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="repertoires")
     */
    private $qvh;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity=FormeJuridique::class, inversedBy="repertoires")
     */
    private $formeJuridique;

    /**
     * @ORM\ManyToOne(targetEntity=RegimeFiscal::class, inversedBy="repertoires")
     */
    private $regimeFiscal;

    /**
     * @ORM\OneToMany(targetEntity=Bilan::class, mappedBy="repertoire")
     */
    private $bilans;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nomDuExpert;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prenomDuExpert;
    
    /**
     * @ORM\OneToMany(targetEntity=CompteDeResultats::class, mappedBy="cuci_rep_code")
     */
    private $compte_de_resultats;

    
    public function __toString()
    {
        return $this->denominationSocial;
    }


    public $activitePrincipaleRepeat;
    public $chiffreAffaire;
    public $valeurAjoutee;
    public $pourcentage;

    /**
     * @ORM\ManyToOne(targetEntity=SystemeComptabilite::class, inversedBy="repertoire")
     */
    private $systemeComptabilite;

    /**
     * @ORM\OneToMany(targetEntity=ImmoBrut::class, mappedBy="repertoire")
     */
    private $immoBruts;




    public function __construct()
    {
        $this->activities = new ArrayCollection();
        $this->commissairesComptes = new ArrayCollection();
        $this->dirigeants = new ArrayCollection();
        $this->actionnaires = new ArrayCollection();
        $this->membreConseils = new ArrayCollection();
        $this->filiales = new ArrayCollection();
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->deleted=true;
        $this->bilans = new ArrayCollection();
        $this->id = Uuid::v4();
        $this->compte_de_resultats = new ArrayCollection();
        $this->immoBruts = new ArrayCollection();
    }


     public function setActivitePrincipaleRepeat(?string $activitePrincipaleRepeat): self
    {
        $this->activitePrincipaleRepeat = $activitePrincipaleRepeat;

        return $this;
    }


     public function getActivitePrincipaleRepeat()
    {
       return $this->activitePrincipaleRepeat ;
    }


     public function getLibelle(): ?string
    {
        return $this->denominationSocial;
    }





   

    public function getId(): ?string
    {
        return $this->id;
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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getActivitePrincipale(): ?string
    {
        return $this->activitePrincipale;
    }

    public function setActivitePrincipale(?string $activitePrincipale): self
    {
        $this->activitePrincipale = $activitePrincipale;

        return $this;
    }

    public function getAddresseDuCabinet(): ?string
    {
        return $this->addresseDuCabinet;
    }

    public function setAddresseDuCabinet(?string $addresseDuCabinet): self
    {
        $this->addresseDuCabinet = $addresseDuCabinet;

        return $this;
    }

    public function getAnneeDeCreation(): ?string
    {
        return $this->anneeDeCreation;
    }

    public function setAnneeDeCreation(?string $anneeDeCreation): self
    {
        $this->anneeDeCreation = $anneeDeCreation;

        return $this;
    }

    public function getAnneeDeFusion(): ?string
    {
        return $this->anneeDeFusion;
    }

    public function setAnneeDeFusion(?string $anneeDeFusion): self
    {
        $this->anneeDeFusion = $anneeDeFusion;

        return $this;
    }

    public function getBoitePostale(): ?string
    {
        return $this->boitePostale;
    }

    public function setBoitePostale(?string $boitePostale): self
    {
        $this->boitePostale = $boitePostale;

        return $this;
    }

    public function getCodeCuci(): ?string
    {
        return $this->codeCuci;
    }

    public function setCodeCuci(?string $codeCuci): self
    {
        $this->codeCuci = $codeCuci;

        return $this;
    }

    public function getCodeImportateur(): ?string
    {
        return $this->codeImportateur;
    }

    public function setCodeImportateur(?string $codeImportateur): self
    {
        $this->codeImportateur = $codeImportateur;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(?string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getControle(): ?Control
    {
        return $this->controle;
    }

    public function setControle(?Control $controle): self
    {
        $this->controle = $controle;

        return $this;
    }

    public function getDateArreteEffectif(): ?\DateTimeInterface
    {
        return $this->dateArreteEffectif;
    }

    public function setDateArreteEffectif(?\DateTimeInterface $dateArreteEffectif): self
    {
        $this->dateArreteEffectif = $dateArreteEffectif;

        return $this;
    }

    public function getDateCessation(): ?\DateTimeInterface
    {
        return $this->dateCessation;
    }

    public function setDateCessation(?\DateTimeInterface $dateCessation): self
    {
        $this->dateCessation = $dateCessation;

        return $this;
    }

    public function getClotureDeExercice(): ?\DateTimeInterface
    {
        return $this->clotureDeExercice;
    }

    public function setClotureDeExercice(?\DateTimeInterface $clotureDeExercice): self
    {
        $this->clotureDeExercice = $clotureDeExercice;

        return $this;
    }

    public function getClotureExercicePrecedent(): ?\DateTimeInterface
    {
        return $this->clotureExercicePrecedent;
    }

    public function setClotureExercicePrecedent(?\DateTimeInterface $clotureExercicePrecedent): self
    {
        $this->clotureExercicePrecedent = $clotureExercicePrecedent;

        return $this;
    }

    public function getDebutExerciceComptable(): ?\DateTimeInterface
    {
        return $this->debutExerciceComptable;
    }

    public function setDebutExerciceComptable(?\DateTimeInterface $debutExerciceComptable): self
    {
        $this->debutExerciceComptable = $debutExerciceComptable;

        return $this;
    }

    public function getFinExerciceComptable(): ?\DateTimeInterface
    {
        return $this->finExerciceComptable;
    }

    public function setFinExerciceComptable(?\DateTimeInterface $finExerciceComptable): self
    {
        $this->finExerciceComptable = $finExerciceComptable;

        return $this;
    }

    public function getDateMiseAjour(): ?\DateTimeInterface
    {
        return $this->dateMiseAjour;
    }

    public function setDateMiseAjour(?\DateTimeInterface $dateMiseAjour): self
    {
        $this->dateMiseAjour = $dateMiseAjour;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    public function getDateReactivation(): ?\DateTimeInterface
    {
        return $this->dateReactivation;
    }

    public function setDateReactivation(?\DateTimeInterface $dateReactivation): self
    {
        $this->dateReactivation = $dateReactivation;

        return $this;
    }

    public function getDenominationSocial(): ?string
    {
        return $this->denominationSocial;
    }

    public function setDenominationSocial(?string $denominationSocial): self
    {
        $this->denominationSocial = $denominationSocial;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(?string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getDureeDeExercice(): ?string
    {
        return $this->dureeDeExercice;
    }

    public function setDureeDeExercice(?string $dureeDeExercice): self
    {
        $this->dureeDeExercice = $dureeDeExercice;

        return $this;
    }

    public function getDureeExercicePrecedent(): ?string
    {
        return $this->dureeExercicePrecedent;
    }

    public function setDureeExercicePrecedent(?string $dureeExercicePrecedent): self
    {
        $this->dureeExercicePrecedent = $dureeExercicePrecedent;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEtablissementsDansPays(): ?string
    {
        return $this->etablissementsDansPays;
    }

    public function setEtablissementsDansPays(?string $etablissementsDansPays): self
    {
        $this->etablissementsDansPays = $etablissementsDansPays;

        return $this;
    }

    public function getEtablissementsHorsPays(): ?string
    {
        return $this->etablissementsHorsPays;
    }

    public function setEtablissementsHorsPays(?string $etablissementsHorsPays): self
    {
        $this->etablissementsHorsPays = $etablissementsHorsPays;

        return $this;
    }

  

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(?string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getNomDuCabinet(): ?string
    {
        return $this->NomDuCabinet;
    }

    public function setNomDuCabinet(?string $NomDuCabinet): self
    {
        $this->NomDuCabinet = $NomDuCabinet;

        return $this;
    }

    public function getNumeroCaisseSociale(): ?string
    {
        return $this->numeroCaisseSociale;
    }

    public function setNumeroCaisseSociale(?string $numeroCaisseSociale): self
    {
        $this->numeroCaisseSociale = $numeroCaisseSociale;

        return $this;
    }

    public function getNumeroRegistreCommerce(): ?string
    {
        return $this->numeroRegistreCommerce;
    }

    public function setNumeroRegistreCommerce(?string $numeroRegistreCommerce): self
    {
        $this->numeroRegistreCommerce = $numeroRegistreCommerce;

        return $this;
    }

    public function getNumeroTelecopie(): ?string
    {
        return $this->numeroTelecopie;
    }

    public function setNumeroTelecopie(?string $numeroTelecopie): self
    {
        $this->numeroTelecopie = $numeroTelecopie;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getPaysDuEntreprise(): ?Pays
    {
        return $this->paysDuEntreprise;
    }

    public function setPaysDuEntreprise(?Pays $paysDuEntreprise): self
    {
        $this->paysDuEntreprise = $paysDuEntreprise;

        return $this;
    }

    public function getPremiereAnneeExercice(): ?string
    {
        return $this->premiereAnneeExercice;
    }

    public function setPremiereAnneeExercice(?string $premiereAnneeExercice): self
    {
        $this->premiereAnneeExercice = $premiereAnneeExercice;

        return $this;
    }

    public function getRaisonCessation(): ?string
    {
        return $this->raisonCessation;
    }

    public function setRaisonCessation(?string $raisonCessation): self
    {
        $this->raisonCessation = $raisonCessation;

        return $this;
    }

    public function getRaisonReactivation(): ?string
    {
        return $this->raisonReactivation;
    }

    public function setRaisonReactivation(?string $raisonReactivation): self
    {
        $this->raisonReactivation = $raisonReactivation;

        return $this;
    }

 

 

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getSigle(): ?string
    {
        return $this->sigle;
    }

    public function setSigle(?string $sigle): self
    {
        $this->sigle = $sigle;

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

    public function getSyscoa(): ?SYSCOA
    {
        return $this->syscoa;
    }

    public function setSyscoa(?SYSCOA $syscoa): self
    {
        $this->syscoa = $syscoa;

        return $this;
    }

 

    public function getTelephone1(): ?string
    {
        return $this->telephone1;
    }

    public function setTelephone1(string $telephone1): self
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function getTelephoneDuCabinet(): ?string
    {
        return $this->telephoneDuCabinet;
    }

    public function setTelephoneDuCabinet(?string $telephoneDuCabinet): self
    {
        $this->telephoneDuCabinet = $telephoneDuCabinet;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAutreFormeJuridique(): ?string
    {
        return $this->autreFormeJuridique;
    }

    public function setAutreFormeJuridique(?string $autreFormeJuridique): self
    {
        $this->autreFormeJuridique = $autreFormeJuridique;

        return $this;
    }

    public function getEnseigne(): ?string
    {
        return $this->enseigne;
    }

    public function setEnseigne(?string $enseigne): self
    {
        $this->enseigne = $enseigne;

        return $this;
    }

    public function getReactivation(): ?string
    {
        return $this->reactivation;
    }

    public function setReactivation(?string $reactivation): self
    {
        $this->reactivation = $reactivation;

        return $this;
    }

    public function getCacr(): ?string
    {
        return $this->cacr;
    }

    public function setCacr(?string $cacr): self
    {
        $this->cacr = $cacr;

        return $this;
    }

    public function getCav(): ?string
    {
        return $this->cav;
    }

    public function setCav(?string $cav): self
    {
        $this->cav = $cav;

        return $this;
    }

    


    public function getUploadedFileName(): ?string
    {
        return $this->uploadedFileName;
    }

    public function setUploadedFileName(?string $uploadedFileName): self
    {
        $this->uploadedFileName = $uploadedFileName;

        return $this;
    }

    public function getAnneeDeReception(): ?string
    {
        return $this->anneeDeReception;
    }

    public function setAnneeDeReception(?string $anneeDeReception): self
    {
        $this->anneeDeReception = $anneeDeReception;

        return $this;
    }

    public function getTypeNINEA(): ?TypeNINEA
    {
        return $this->typeNINEA;
    }

    public function setTypeNINEA(?TypeNINEA $typeNINEA): self
    {
        $this->typeNINEA = $typeNINEA;

        return $this;
    }

    /**
     * @return Collection|Activities[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activities $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setRepertoire($this);
        }

        return $this;
    }

    public function removeActivity(Activities $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getRepertoire() === $this) {
                $activity->setRepertoire(null);
            }
        }

        return $this;
    }


    public function getNaema(): ?NAEMA
    {
        return $this->naema;
    }

    public function setNaema(?NAEMA $naema): self
    {
        $this->naema = $naema;

        return $this;
    }

    public function getNaemas(): ?NAEMAS
    {
        return $this->naemas;
    }

    public function setNaemas(?NAEMAS $naemas): self
    {
        $this->naemas = $naemas;

        return $this;
    }

    public function getCiti(): ?Citi
    {
        return $this->citi;
    }

    public function setCiti(?Citi $citi): self
    {
        $this->citi = $citi;

        return $this;
    }

    public function getNomDuContact(): ?string
    {
        return $this->NomDuContact;
    }

    public function setNomDuContact(?string $NomDuContact): self
    {
        $this->NomDuContact = $NomDuContact;

        return $this;
    }

    public function getPrenomDuContact(): ?string
    {
        return $this->prenomDuContact;
    }

    public function setPrenomDuContact(?string $prenomDuContact): self
    {
        $this->prenomDuContact = $prenomDuContact;

        return $this;
    }

    public function getAddresseDuContact(): ?string
    {
        return $this->addresseDuContact;
    }

    public function setAddresseDuContact(?string $addresseDuContact): self
    {
        $this->addresseDuContact = $addresseDuContact;

        return $this;
    }

    public function getAddresseComplete(): ?string
    {
        return $this->addresseComplete;
    }

    public function setAddresseComplete(?string $addresseComplete): self
    {
        $this->addresseComplete = $addresseComplete;

        return $this;
    }

    /**
     * @return Collection|CommissairesComptes[]
     */
    public function getCommissairesComptes(): Collection
    {
        return $this->commissairesComptes;
    }

    public function addCommissairesCompte(CommissairesComptes $commissairesCompte): self
    {
        if (!$this->commissairesComptes->contains($commissairesCompte)) {
            $this->commissairesComptes[] = $commissairesCompte;
            $commissairesCompte->setRepertoire($this);
        }

        return $this;
    }

    public function removeCommissairesCompte(CommissairesComptes $commissairesCompte): self
    {
        if ($this->commissairesComptes->removeElement($commissairesCompte)) {
            // set the owning side to null (unless already changed)
            if ($commissairesCompte->getRepertoire() === $this) {
                $commissairesCompte->setRepertoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dirigeant[]
     */
    public function getDirigeants(): Collection
    {
        return $this->dirigeants;
    }

    public function addDirigeant(Dirigeant $dirigeant): self
    {
        if (!$this->dirigeants->contains($dirigeant)) {
            $this->dirigeants[] = $dirigeant;
            $dirigeant->setRepertoire($this);
        }

        return $this;
    }

    public function removeDirigeant(Dirigeant $dirigeant): self
    {
        if ($this->dirigeants->removeElement($dirigeant)) {
            // set the owning side to null (unless already changed)
            if ($dirigeant->getRepertoire() === $this) {
                $dirigeant->setRepertoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Actionnaire[]
     */
    public function getActionnaires(): Collection
    {
        return $this->actionnaires;
    }

    public function addActionnaire(Actionnaire $actionnaire): self
    {
        if (!$this->actionnaires->contains($actionnaire)) {
            $this->actionnaires[] = $actionnaire;
            $actionnaire->setRepertoire($this);
        }

        return $this;
    }

    public function removeActionnaire(Actionnaire $actionnaire): self
    {
        if ($this->actionnaires->removeElement($actionnaire)) {
            // set the owning side to null (unless already changed)
            if ($actionnaire->getRepertoire() === $this) {
                $actionnaire->setRepertoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MembreConseil[]
     */
    public function getMembreConseils(): Collection
    {
        return $this->membreConseils;
    }

    public function addMembreConseil(MembreConseil $membreConseil): self
    {
        if (!$this->membreConseils->contains($membreConseil)) {
            $this->membreConseils[] = $membreConseil;
            $membreConseil->setRepertoire($this);
        }

        return $this;
    }

    public function removeMembreConseil(MembreConseil $membreConseil): self
    {
        if ($this->membreConseils->removeElement($membreConseil)) {
            // set the owning side to null (unless already changed)
            if ($membreConseil->getRepertoire() === $this) {
                $membreConseil->setRepertoire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Filiales[]
     */
    public function getFiliales(): Collection
    {
        return $this->filiales;
    }

    public function addFiliale(Filiales $filiale): self
    {
        if (!$this->filiales->contains($filiale)) {
            $this->filiales[] = $filiale;
            $filiale->setRepertoire($this);
        }

        return $this;
    }

    public function removeFiliale(Filiales $filiale): self
    {
        if ($this->filiales->removeElement($filiale)) {
            // set the owning side to null (unless already changed)
            if ($filiale->getRepertoire() === $this) {
                $filiale->setRepertoire(null);
            }
        }

        return $this;
    }

    public function getQvh(): ?QVH
    {
        return $this->qvh;
    }

    public function setQvh(?QVH $qvh): self
    {
        $this->qvh = $qvh;

        return $this;
    }


     public function getFonctionDucontact(): ?Qualite
    {
        return $this->fonctionDucontact;
    }

    public function setFonctionDucontact(?Qualite $fonctionDucontact): self
    {
        $this->fonctionDucontact = $fonctionDucontact;

        return $this;
    }

    

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getFormeJuridique(): ?FormeJuridique
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(?FormeJuridique $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getRegimeFiscal(): ?RegimeFiscal
    {
        return $this->regimeFiscal;
    }

    public function setRegimeFiscal(?RegimeFiscal $regimeFiscal): self
    {
        $this->regimeFiscal = $regimeFiscal;

        return $this;
    }

    /**
     * @return Collection|Bilan[]
     */
    public function getBilans(): Collection
    {
        return $this->bilans;
    }

    public function addBilan(Bilan $bilan): self
    {
        if (!$this->bilans->contains($bilan)) {
            $this->bilans[] = $bilan;
            $bilan->setRepertoire($this);
        }

        return $this;
    }

    public function removeBilan(Bilan $bilan): self
    {
        if ($this->bilans->removeElement($bilan)) {
            // set the owning side to null (unless already changed)
            if ($bilan->getRepertoire() === $this) {
                $bilan->setRepertoire(null);
            }
        }

        return $this;
    }

    public function getNomDuExpert(): ?string
    {
        return $this->nomDuExpert;
    }

    public function setNomDuExpert(?string $nomDuExpert): self
    {
        $this->nomDuExpert = $nomDuExpert;

        return $this;
    }

    public function getPrenomDuExpert(): ?string
    {
        return $this->prenomDuExpert;
    }

    public function setPrenomDuExpert(?string $prenomDuExpert): self
    {
        $this->prenomDuExpert = $prenomDuExpert;

        return $this;
    }

    public function getSystemeComptabilite(): ?SystemeComptabilite
    {
        return $this->systemeComptabilite;
    }

    public function setSystemeComptabilite(?SystemeComptabilite $systemeComptabilite): void
    {
        $this->systemeComptabilite = $systemeComptabilite;
    }
    

    /**
     * @return Collection|CompteDeResultats[]
     */
    public function getCompteDeResultats(): Collection
    {
        return $this->compte_de_resultats;
    }

    public function addCompteDeResultat(CompteDeResultats $compteDeResultat): self
    {
        if (!$this->compte_de_resultats->contains($compteDeResultat)) {
            $this->compte_de_resultats[] = $compteDeResultat;
            $compteDeResultat->setCuciRepCode($this);
        }

        return $this;
    }

    public function removeCompteDeResultat(CompteDeResultats $compteDeResultat): self
    {
        if ($this->compte_de_resultats->removeElement($compteDeResultat)) {
            // set the owning side to null (unless already changed)
            if ($compteDeResultat->getCuciRepCode() === $this) {
                $compteDeResultat->setCuciRepCode(null);
            }
        }


        return $this;
    }

    /**
     * @return Collection|ImmoBrut[]
     */
    public function getImmoBruts(): Collection
    {
        return $this->immoBruts;
    }

    public function addImmoBrut(ImmoBrut $immoBrut): self
    {
        if (!$this->immoBruts->contains($immoBrut)) {
            $this->immoBruts[] = $immoBrut;
            $immoBrut->setRepertoire($this);
        }

        return $this;
    }

    public function removeImmoBrut(ImmoBrut $immoBrut): self
    {
        if ($this->immoBruts->removeElement($immoBrut)) {
            // set the owning side to null (unless already changed)
            if ($immoBrut->getRepertoire() === $this) {
                $immoBrut->setRepertoire(null);
            }
        }

        return $this;
    }

}
