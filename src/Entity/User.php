<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`utilisateur`")
 * @UniqueEntity(fields={"username"}, message="Il existe déjà un compte avec ce nom d'utilisateur.")
 * @Gedmo\Loggable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     * 

     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     * @Gedmo\Versioned
     * 

     */
    private $nom;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieuNaissance;


     /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     *

     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tel;


     /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * 
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     * 

     */
    private $username;

   
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;



      /**
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled=1;



    /**
     * @ORM\Column(type="array", nullable=true)
     * 
     */
    private $roles;


      /**
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted=0;


     /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nombreEssai;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $premierConnexion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateExpiration;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="createdBy")
     */
    private $repertoires;

    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="updatedBy")
     */
    private $repertoireUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="createBy")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity=Activities::class, mappedBy="updatedBy")
     */
    private $activitiesUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=CommissairesComptes::class, mappedBy="createdBy")
     */
    private $commissairesComptes;

    /**
     * @ORM\OneToMany(targetEntity=CommissairesComptes::class, mappedBy="modifiedby")
     */
    private $commissairesComtesModifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=Dirigeant::class, mappedBy="createdBy")
     */
    private $dirigeants;

    /**
     * @ORM\OneToMany(targetEntity=Dirigeant::class, mappedBy="modifiedBy")
     */
    private $dirigeantsModifiedby;

   

    /**
     * @ORM\OneToMany(targetEntity=Actionnaire::class, mappedBy="modifiedBy")
     */
    private $actionnairesModifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=MembreConseil::class, mappedBy="createdBy")
     */
    private $membreConseils;

    /**
     * @ORM\OneToMany(targetEntity=MembreConseil::class, mappedBy="modifiedBy")
     */
    private $membreConseilsModifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=Filiales::class, mappedBy="createdBy")
     */
    private $filiales;

    /**
     * @ORM\OneToMany(targetEntity=Filiales::class, mappedBy="modifiedBy")
     */
    private $filialesModified;

    /**
     * @ORM\OneToMany(targetEntity=Bilan::class, mappedBy="createdBy")
     */
    private $bilans;

    /**
     * @ORM\OneToMany(targetEntity=Bilan::class, fetch="EXTRA_LAZY", orphanRemoval=true, cascade={"persist"}, mappedBy="modifiedBy")
     */
    private $bilansModifiedby;

    /**
     * @ORM\OneToMany(targetEntity=ImmoBrut::class, mappedBy="createdby")
     */
    private $immoBruts;

    /**
     * @ORM\OneToMany(targetEntity=ImmoBrut::class, mappedBy="modifiedby")
     */
    private $immoBrutBy;
    
    /**
     * @ORM\OneToMany(targetEntity=CuciImmoPlus::class, mappedBy="createdBy")
     */
    private $cuciImmoPluses;
    
    /**
     * @ORM\OneToMany(targetEntity=CuciImmoPlus::class, mappedBy="modifiedBy")
     */
    private $cuciImmoPlusesBy;
   

    /**
     * @ORM\OneToMany(targetEntity=ProductionDeExercice::class, mappedBy="createdBy")
     */
    private $productionDeExercices;

    /**
     * @ORM\OneToMany(targetEntity=ProductionDeExercice::class, mappedBy="updatedBy")
     */
    private $productionDeExercicesUpBy;

    /**
     * @ORM\OneToMany(targetEntity=Effectifs::class, mappedBy="createdBy")
     */
    private $effectifs;
    
    /**
     * @ORM\OneToMany(targetEntity=Effectifs::class, mappedBy="updatedBy")
     */
    private $effectifsUpBy;

    /**
     * @ORM\OneToMany(targetEntity=NiPersonne::class, mappedBy="created_by")
     */
    private $niPersonnes;


    

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="createdBy")
     */
    private $nINineas;



     /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="modifiedBy")
     */
    private $nINineaModifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=NiActiviteEconomique::class, mappedBy="createBy")
     */
    private $niActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class, mappedBy="createdBy")
     */
    private $niDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=CuciMigLog::class, mappedBy="createdBy")
     */
    private $cuciMigLogs;

    /**
     * @ORM\OneToMany(targetEntity=CuciMigLog::class, mappedBy="modifiedBy")
     */
    private $cuciMiglogsModifier;

    /**
     * @ORM\ManyToOne(targetEntity=NiAdministration::class, inversedBy="users")
     */
    private $niAdministration;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="createdBy")
     */
    private $niNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="updatedBy")
     */
    private $niNineapropositionsUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=BilanSmt::class, mappedBy="createdBy")
     */
    private $bilanSmts;

    /**
     * @ORM\OneToMany(targetEntity=BilanSmt::class, mappedBy="updatedBy")
     */
    private $bilanSmtsUpdatedby;

    /**
     * @ORM\OneToMany(targetEntity=ComptederesultatSmt::class, mappedBy="createdBy")
     */
    private $comptederesultatSmts;

    /**
     * @ORM\OneToMany(targetEntity=ComptederesultatSmt::class, mappedBy="updatedBy")
     */
    private $comptederesultatSmtupdatedby;

    /**
     * @ORM\OneToMany(targetEntity=CompteDeResultats::class, mappedBy="modifiedBy")
     */
    private $compteDeResultats;
    
    /**
     * @ORM\OneToMany(targetEntity=CompteDeResultats::class, mappedBy="createdBy")
     */
    private $compteDeResultatsUpBy;

    /**
     * @ORM\OneToMany(targetEntity=SuiviMaterielMobilier::class, mappedBy="createdBy")
     */
    private $modifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=SuiviMaterielMobilier::class, mappedBy="relation")
     */
    private $suiviMaterielMobiliers;

    /**
     * @ORM\OneToMany(targetEntity=SuiviMaterielMobilier::class, mappedBy="updatedBy")
     */
    private $suiviMaterielMobiliersBy;

    /**
     * @ORM\OneToMany(targetEntity=SuiviMaterielMobilierCaution::class, mappedBy="createdBy")
     */
    private $suiviMaterielMobilierCautions;

    /**
     * @ORM\OneToMany(targetEntity=SuiviMaterielMobilierCaution::class, mappedBy="modifiedBy")
     */
    private $suiviMaterielMobiliersCautionsModifiedBy;

    /**
     * @ORM\OneToMany(targetEntity=EtatDesStocksSmt::class, mappedBy="createdBy")
     */
    private $etatDesStocksSmts;

    /**
     * @ORM\OneToMany(targetEntity=EtatDesStocksSmt::class, mappedBy="updatedBy")
     */
    private $etatDesStocksSmtsUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=DettesCreancesSmt::class, mappedBy="createdBy")
     */
    private $dettesCreancesSmts;

    /**
     * @ORM\OneToMany(targetEntity=FluxDesTresoreries::class, mappedBy="modifiedBy")
     */
    private $fluxDesTresoreries;

    /**
     * @ORM\OneToMany(targetEntity=FluxDesTresoreries::class, mappedBy="editedBy")
     */
    private $fluxDesTresoreriesUpBy;

    /**
     * @ORM\OneToMany(targetEntity=AchatProduction::class, mappedBy="createdBy")
     */
    private $achatProductions;

    /**
     * @ORM\OneToMany(targetEntity=AchatProduction::class, mappedBy="updatedBy")
     */
    private $achatProductionsUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=JournalTresorerie::class, mappedBy="createdBy")
     */
    private $journalTresoreries;

    /**
     * @ORM\OneToMany(targetEntity=JournalCreancesImpayeesSmt::class, mappedBy="createdBy")
     */
    private $journalCreancesImpayeesSmts;

    /**
     * @ORM\OneToMany(targetEntity=JournalCreancesImpayeesSmt::class, mappedBy="updatedBy")
     */
    private $journalCreancesImpayeesSmtUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=JournalDettesPayerSmt::class, mappedBy="createdBy")
     */
    private $journalDettesPayerSmts;

    /**
     * @ORM\OneToMany(targetEntity=JournalDettesPayerSmt::class, mappedBy="updatedBy")
     */
    private $journalDettesPayerSmtsUpdatedBy;

    /**
     * @ORM\OneToMany(targetEntity=NiCessation::class, mappedBy="createdBy")
     */
    private $niCessations;

    /**
     * @ORM\OneToMany(targetEntity=NiCessation::class, mappedBy="updatedBy")
     */
    private $niCessationeditbys;

    /**
     * @ORM\OneToMany(targetEntity=Nireactivation::class, mappedBy="createdBy")
     */
    private $nireactivations;

    /**
     * @ORM\OneToMany(targetEntity=Nireactivation::class, mappedBy="updatedBy")
     */
    private $nireactivationedits;

    /**
     * @ORM\OneToMany(targetEntity=NinJourFerier::class, mappedBy="createdBy")
     */
    private $ninJourFeriers;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActivite::class, mappedBy="createdBy")
     */
    private $historyNiActivites;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActiviteEconomique::class, mappedBy="createBy")
     */
    private $historyNiActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="createdBy")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiPersonne::class, mappedBy="createdBy")
     */
    private $historyNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiNineaproposition::class, mappedBy="createdBy")
     */
    private $historyNiNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNINinea::class, mappedBy="createdBy")
     */
    private $historyNINineas;

    /**
     * @ORM\OneToMany(targetEntity=TempNiActivite::class, mappedBy="createdBy")
     */
    private $tempNiActivites;

    /**
     * @ORM\OneToMany(targetEntity=TempNiActiviteEconomique::class, mappedBy="createdBy")
     */
    private $tempNiActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=TempNiCessation::class, mappedBy="createdBy")
     */
    private $tempNiCessations;

    /**
     * @ORM\OneToMany(targetEntity=TempNiCoordonnees::class, mappedBy="createdBy")
     */
    private $tempNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="createdBy")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="createdBy")
     */
    private $tempNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNINinea::class, mappedBy="createdBy")
     */
    private $tempNINineas;

    /**
     * @ORM\OneToMany(targetEntity=DemandeModification::class, mappedBy="createdBy")
     */
    private $demandeModifications;

    /**
     * @ORM\OneToMany(targetEntity=DemandeModification::class, mappedBy="updatedBy")
     */
    private $demandeUpdatedBy;

   

   


    public function __construct()
    {
       
        $this->roles = array();
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt;
        $this->repertoires = new ArrayCollection();
        $this->repertoireUpdatedBy = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->activitiesUpdatedBy = new ArrayCollection();
        $this->commissairesComptes = new ArrayCollection();
        $this->commissairesComtesModifiedBy = new ArrayCollection();
        $this->dirigeants = new ArrayCollection();
        $this->dirigeantsModifiedby = new ArrayCollection();
        
        $this->actionnairesModifiedBy = new ArrayCollection();
        $this->membreConseils = new ArrayCollection();
        $this->membreConseilsModifiedBy = new ArrayCollection();
        $this->filiales = new ArrayCollection();
        $this->filialesModified = new ArrayCollection();
        $this->bilans = new ArrayCollection();
        $this->bilansModifiedby = new ArrayCollection();
        $this->id = uniqid();
        $this->immoBruts = new ArrayCollection();
        $this->immoBrutBy = new ArrayCollection();
        $this->cuciImmoPluses = new ArrayCollection();
      
        $this->productionDeExercices = new ArrayCollection();
        $this->effectifs = new ArrayCollection();
        $this->niPersonnes = new ArrayCollection();
        $this->nINineas = new ArrayCollection();
        $this->niActiviteEconomiques = new ArrayCollection();
        $this->niDirigeants = new ArrayCollection();
        $this->cuciMigLogs = new ArrayCollection();
        $this->cuciMiglogsModifier = new ArrayCollection();
        $this->niNineapropositions = new ArrayCollection();
        $this->niNineapropositionsUpdatedBy = new ArrayCollection();
        $this->bilanSmts = new ArrayCollection();
        $this->bilanSmtsUpdatedby = new ArrayCollection();
        $this->comptederesultatSmts = new ArrayCollection();
        $this->comptederesultatSmtupdatedby = new ArrayCollection();
        $this->compteDeResultats = new ArrayCollection();
        $this->modifiedBy = new ArrayCollection();
        $this->suiviMaterielMobiliers = new ArrayCollection();
        $this->suiviMaterielMobiliersBy = new ArrayCollection();
        $this->suiviMaterielMobilierCautions = new ArrayCollection();
        $this->suiviMaterielMobiliersCautionsModifiedBy = new ArrayCollection();
        $this->etatDesStocksSmts = new ArrayCollection();
        $this->etatDesStocksSmtsUpdatedBy = new ArrayCollection();
        $this->dettesCreancesSmts = new ArrayCollection();
        $this->fluxDesTresoreries = new ArrayCollection();
        $this->achatProductions = new ArrayCollection();
        $this->achatProductionsUpdatedBy = new ArrayCollection();
        $this->journalTresoreries = new ArrayCollection();
        $this->journalCreancesImpayeesSmts = new ArrayCollection();
        $this->journalCreancesImpayeesSmtUpdatedBy = new ArrayCollection();
        $this->journalDettesPayerSmts = new ArrayCollection();
        $this->journalDettesPayerSmtsUpdatedBy = new ArrayCollection();
        $this->cuciImmoPlusesBy = new ArrayCollection();
        $this->productionDeExercicesUpBy = new ArrayCollection();
        $this->effectifsUpBy = new ArrayCollection();
        $this->compteDeResultatsUpBy = new ArrayCollection();
        $this->fluxDesTresoreriesUpBy = new ArrayCollection();
        $this->nINineaModifiedBy = new ArrayCollection();
        $this->niCessations = new ArrayCollection();
        $this->niCessationeditbys = new ArrayCollection();
        $this->nireactivations = new ArrayCollection();
        $this->nireactivationedits = new ArrayCollection();
        $this->ninJourFeriers = new ArrayCollection();
        $this->historyNiActivites = new ArrayCollection();
        $this->historyNiActiviteEconomiques = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNiPersonnes = new ArrayCollection();
        $this->historyNiNineapropositions = new ArrayCollection();
        $this->historyNINineas = new ArrayCollection();
        $this->tempNiActivites = new ArrayCollection();
        $this->tempNiActiviteEconomiques = new ArrayCollection();
        $this->tempNiCessations = new ArrayCollection();
        $this->tempNiCoordonnees = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
        $this->tempNINineas = new ArrayCollection();
        $this->demandeModifications = new ArrayCollection();
        $this->demandeUpdatedBy = new ArrayCollection();
      
    }


     /**
    * toString
    * @return string
    */
   public function __toString()
   {
           return $this->nom;
          
   }

    public function getPrenomNom()
    {
        return  $this->prenom." ". $this->nom;
    }


    public function updatedAt(): self
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function addRoles($role): self
    {
        if (!in_array($role,$this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }



    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The deleted
     */
    public function getDeleted(){
          
          return $this->deleted;
    }


    public function setDeleted(string $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }


    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The enabled
     */
    public function getEnabled(){
          
          return $this->enabled;
    }


    public function setEnabled(string $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

     public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
     public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

     public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(?string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNombreEssai(): ?int
    {
        return $this->nombreEssai;
    }

    public function setNombreEssai(?int $nombreEssai): self
    {
        $this->nombreEssai = $nombreEssai;

        return $this;
    }

    public function getPremierConnexion(): ?bool
    {
        return $this->premierConnexion;
    }

    public function setPremierConnexion(?bool $premierConnexion): self
    {
        $this->premierConnexion = $premierConnexion;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoires(): Collection
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setCreatedBy($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getCreatedBy() === $this) {
                $repertoire->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Repertoire[]
     */
    public function getRepertoireUpdatedBy(): Collection
    {
        return $this->repertoireUpdatedBy;
    }

    public function addRepertoireUpdatedBy(Repertoire $repertoireUpdatedBy): self
    {
        if (!$this->repertoireUpdatedBy->contains($repertoireUpdatedBy)) {
            $this->repertoireUpdatedBy[] = $repertoireUpdatedBy;
            $repertoireUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeRepertoireUpdatedBy(Repertoire $repertoireUpdatedBy): self
    {
        if ($this->repertoireUpdatedBy->removeElement($repertoireUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($repertoireUpdatedBy->getUpdatedBy() === $this) {
                $repertoireUpdatedBy->setUpdatedBy(null);
            }
        }

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
            $activity->setCreateBy($this);
        }

        return $this;
    }

    public function removeActivity(Activities $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getCreateBy() === $this) {
                $activity->setCreateBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Activities[]
     */
    public function getActivitiesUpdatedBy(): Collection
    {
        return $this->activitiesUpdatedBy;
    }

    public function addActivitiesUpdatedBy(Activities $activitiesUpdatedBy): self
    {
        if (!$this->activitiesUpdatedBy->contains($activitiesUpdatedBy)) {
            $this->activitiesUpdatedBy[] = $activitiesUpdatedBy;
            $activitiesUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeActivitiesUpdatedBy(Activities $activitiesUpdatedBy): self
    {
        if ($this->activitiesUpdatedBy->removeElement($activitiesUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($activitiesUpdatedBy->getUpdatedBy() === $this) {
                $activitiesUpdatedBy->setUpdatedBy(null);
            }
        }

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
            $commissairesCompte->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCommissairesCompte(CommissairesComptes $commissairesCompte): self
    {
        if ($this->commissairesComptes->removeElement($commissairesCompte)) {
            // set the owning side to null (unless already changed)
            if ($commissairesCompte->getCreatedBy() === $this) {
                $commissairesCompte->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommissairesComptes[]
     */
    public function getCommissairesComtesModifiedBy(): Collection
    {
        return $this->commissairesComtesModifiedBy;
    }

    public function addCommissairesComtesModifiedBy(CommissairesComptes $commissairesComtesModifiedBy): self
    {
        if (!$this->commissairesComtesModifiedBy->contains($commissairesComtesModifiedBy)) {
            $this->commissairesComtesModifiedBy[] = $commissairesComtesModifiedBy;
            $commissairesComtesModifiedBy->setModifiedby($this);
        }

        return $this;
    }

    public function removeCommissairesComtesModifiedBy(CommissairesComptes $commissairesComtesModifiedBy): self
    {
        if ($this->commissairesComtesModifiedBy->removeElement($commissairesComtesModifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($commissairesComtesModifiedBy->getModifiedby() === $this) {
                $commissairesComtesModifiedBy->setModifiedby(null);
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
            $dirigeant->setCreatedBy($this);
        }

        return $this;
    }

    public function removeDirigeant(Dirigeant $dirigeant): self
    {
        if ($this->dirigeants->removeElement($dirigeant)) {
            // set the owning side to null (unless already changed)
            if ($dirigeant->getCreatedBy() === $this) {
                $dirigeant->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dirigeant[]
     */
    public function getDirigeantsModifiedby(): Collection
    {
        return $this->dirigeantsModifiedby;
    }

    public function addDirigeantsModifiedby(Dirigeant $dirigeantsModifiedby): self
    {
        if (!$this->dirigeantsModifiedby->contains($dirigeantsModifiedby)) {
            $this->dirigeantsModifiedby[] = $dirigeantsModifiedby;
            $dirigeantsModifiedby->setModifiedBy($this);
        }

        return $this;
    }

    public function removeDirigeantsModifiedby(Dirigeant $dirigeantsModifiedby): self
    {
        if ($this->dirigeantsModifiedby->removeElement($dirigeantsModifiedby)) {
            // set the owning side to null (unless already changed)
            if ($dirigeantsModifiedby->getModifiedBy() === $this) {
                $dirigeantsModifiedby->setModifiedBy(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection|Actionnaire[]
     */
    public function getActionnairesModifiedBy(): Collection
    {
        return $this->actionnairesModifiedBy;
    }

    public function addActionnairesModifiedBy(Actionnaire $actionnairesModifiedBy): self
    {
        if (!$this->actionnairesModifiedBy->contains($actionnairesModifiedBy)) {
            $this->actionnairesModifiedBy[] = $actionnairesModifiedBy;
            $actionnairesModifiedBy->setModifiedBy($this);
        }

        return $this;
    }

    public function removeActionnairesModifiedBy(Actionnaire $actionnairesModifiedBy): self
    {
        if ($this->actionnairesModifiedBy->removeElement($actionnairesModifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($actionnairesModifiedBy->getModifiedBy() === $this) {
                $actionnairesModifiedBy->setModifiedBy(null);
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
            $membreConseil->setCreatedBy($this);
        }

        return $this;
    }

    public function removeMembreConseil(MembreConseil $membreConseil): self
    {
        if ($this->membreConseils->removeElement($membreConseil)) {
            // set the owning side to null (unless already changed)
            if ($membreConseil->getCreatedBy() === $this) {
                $membreConseil->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MembreConseil[]
     */
    public function getMembreConseilsModifiedBy(): Collection
    {
        return $this->membreConseilsModifiedBy;
    }

    public function addMembreConseilsModifiedBy(MembreConseil $membreConseilsModifiedBy): self
    {
        if (!$this->membreConseilsModifiedBy->contains($membreConseilsModifiedBy)) {
            $this->membreConseilsModifiedBy[] = $membreConseilsModifiedBy;
            $membreConseilsModifiedBy->setModifiedBy($this);
        }

        return $this;
    }

    public function removeMembreConseilsModifiedBy(MembreConseil $membreConseilsModifiedBy): self
    {
        if ($this->membreConseilsModifiedBy->removeElement($membreConseilsModifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($membreConseilsModifiedBy->getModifiedBy() === $this) {
                $membreConseilsModifiedBy->setModifiedBy(null);
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
            $filiale->setCreatedBy($this);
        }

        return $this;
    }

    public function removeFiliale(Filiales $filiale): self
    {
        if ($this->filiales->removeElement($filiale)) {
            // set the owning side to null (unless already changed)
            if ($filiale->getCreatedBy() === $this) {
                $filiale->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Filiales[]
     */
    public function getFilialesModified(): Collection
    {
        return $this->filialesModified;
    }

    public function addFilialesModified(Filiales $filialesModified): self
    {
        if (!$this->filialesModified->contains($filialesModified)) {
            $this->filialesModified[] = $filialesModified;
            $filialesModified->setModifiedBy($this);
        }

        return $this;
    }

    public function removeFilialesModified(Filiales $filialesModified): self
    {
        if ($this->filialesModified->removeElement($filialesModified)) {
            // set the owning side to null (unless already changed)
            if ($filialesModified->getModifiedBy() === $this) {
                $filialesModified->setModifiedBy(null);
            }
        }

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
            $bilan->setCreatedBy($this);
        }

        return $this;
    }

    public function removeBilan(Bilan $bilan): self
    {
        if ($this->bilans->removeElement($bilan)) {
            // set the owning side to null (unless already changed)
            if ($bilan->getCreatedBy() === $this) {
                $bilan->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bilan[]
     */
    public function getBilansModifiedby(): Collection
    {
        return $this->bilansModifiedby;
    }

    public function addBilansModifiedby(Bilan $bilansModifiedby): self
    {
        if (!$this->bilansModifiedby->contains($bilansModifiedby)) {
            $this->bilansModifiedby[] = $bilansModifiedby;
            $bilansModifiedby->setModifiedBy($this);
        }

        return $this;
    }

    public function removeBilansModifiedby(Bilan $bilansModifiedby): self
    {
        if ($this->bilansModifiedby->removeElement($bilansModifiedby)) {
            // set the owning side to null (unless already changed)
            if ($bilansModifiedby->getModifiedBy() === $this) {
                $bilansModifiedby->setModifiedBy(null);
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
            $immoBrut->setCreatedby($this);
        }

        return $this;
    }

    public function removeImmoBrut(ImmoBrut $immoBrut): self
    {
        if ($this->immoBruts->removeElement($immoBrut)) {
            // set the owning side to null (unless already changed)
            if ($immoBrut->getCreatedby() === $this) {
                $immoBrut->setCreatedby(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ImmoBrut[]
     */
    public function getImmoBrutBy(): Collection
    {
        return $this->immoBrutBy;
    }

    public function addImmoBrutBy(ImmoBrut $immoBrutBy): self
    {
        if (!$this->immoBrutBy->contains($immoBrutBy)) {
            $this->immoBrutBy[] = $immoBrutBy;
            $immoBrutBy->setModifiedby($this);
        }

        return $this;
    }

    public function removeImmoBrutBy(ImmoBrut $immoBrutBy): self
    {
        if ($this->immoBrutBy->removeElement($immoBrutBy)) {
            // set the owning side to null (unless already changed)
            if ($immoBrutBy->getModifiedby() === $this) {
                $immoBrutBy->setModifiedby(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CuciImmoPlus>
     */
    public function getCuciImmoPluses(): Collection
    {
        return $this->cuciImmoPluses;
    }

    public function addCuciImmoPlus(CuciImmoPlus $cuciImmoPlus): self
    {
        if (!$this->cuciImmoPluses->contains($cuciImmoPlus)) {
            $this->cuciImmoPluses[] = $cuciImmoPlus;
            $cuciImmoPlus->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCuciImmoPlus(CuciImmoPlus $cuciImmoPlus): self
    {
        if ($this->cuciImmoPluses->removeElement($cuciImmoPlus)) {
            // set the owning side to null (unless already changed)
            if ($cuciImmoPlus->getCreatedBy() === $this) {
                $cuciImmoPlus->setCreatedBy(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, ProductionDeExercice>
     */
    public function getProductionDeExercices(): Collection
    {
        return $this->productionDeExercices;
    }

    public function addProductionDeExercice(ProductionDeExercice $productionDeExercice): self
    {
        if (!$this->productionDeExercices->contains($productionDeExercice)) {
            $this->productionDeExercices[] = $productionDeExercice;
            $productionDeExercice->setCreatedBy($this);
        }

        return $this;
    }

    public function removeProductionDeExercice(ProductionDeExercice $productionDeExercice): self
    {
        if ($this->productionDeExercices->removeElement($productionDeExercice)) {
            // set the owning side to null (unless already changed)
            if ($productionDeExercice->getCreatedBy() === $this) {
                $productionDeExercice->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Effectifs>
     */
    public function getEffectifs(): Collection
    {
        return $this->effectifs;
    }

    public function addEffectif(Effectifs $effectif): self
    {
        if (!$this->effectifs->contains($effectif)) {
            $this->effectifs[] = $effectif;
            $effectif->setCreatedBy($this);
        }

        return $this;
    }

    public function removeEffectif(Effectifs $effectif): self
    {
        if ($this->effectifs->removeElement($effectif)) {
            // set the owning side to null (unless already changed)
            if ($effectif->getCreatedBy() === $this) {
                $effectif->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiPersonne>
     */
    public function getNiPersonnes(): Collection
    {
        return $this->niPersonnes;
    }

    public function addNiPersonne(NiPersonne $niPersonne): self
    {
        if (!$this->niPersonnes->contains($niPersonne)) {
            $this->niPersonnes[] = $niPersonne;
            $niPersonne->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNiPersonne(NiPersonne $niPersonne): self
    {
        if ($this->niPersonnes->removeElement($niPersonne)) {
            // set the owning side to null (unless already changed)
            if ($niPersonne->getCreatedBy() === $this) {
                $niPersonne->setCreatedBy(null);
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
            $nINinea->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNINinea(NINinea $nINinea): self
    {
        if ($this->nINineas->removeElement($nINinea)) {
            // set the owning side to null (unless already changed)
            if ($nINinea->getCreatedBy() === $this) {
                $nINinea->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiActiviteEconomique>
     */
    public function getNiActiviteEconomiques(): Collection
    {
        return $this->niActiviteEconomiques;
    }

    public function addNiActiviteEconomique(NiActiviteEconomique $niActiviteEconomique): self
    {
        if (!$this->niActiviteEconomiques->contains($niActiviteEconomique)) {
            $this->niActiviteEconomiques[] = $niActiviteEconomique;
            $niActiviteEconomique->setCreateBy($this);
        }

        return $this;
    }

    public function removeNiActiviteEconomique(NiActiviteEconomique $niActiviteEconomique): self
    {
        if ($this->niActiviteEconomiques->removeElement($niActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($niActiviteEconomique->getCreateBy() === $this) {
                $niActiviteEconomique->setCreateBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiDirigeant>
     */
    public function getNiDirigeants(): Collection
    {
        return $this->niDirigeants;
    }

    public function addNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if (!$this->niDirigeants->contains($niDirigeant)) {
            $this->niDirigeants[] = $niDirigeant;
            $niDirigeant->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if ($this->niDirigeants->removeElement($niDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($niDirigeant->getCreatedBy() === $this) {
                $niDirigeant->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CuciMigLog>
     */
    public function getCuciMigLogs(): Collection
    {
        return $this->cuciMigLogs;
    }

    public function addCuciMigLog(CuciMigLog $cuciMigLog): self
    {
        if (!$this->cuciMigLogs->contains($cuciMigLog)) {
            $this->cuciMigLogs[] = $cuciMigLog;
            $cuciMigLog->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCuciMigLog(CuciMigLog $cuciMigLog): self
    {
        if ($this->cuciMigLogs->removeElement($cuciMigLog)) {
            // set the owning side to null (unless already changed)
            if ($cuciMigLog->getCreatedBy() === $this) {
                $cuciMigLog->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CuciMigLog>
     */
    public function getCuciMiglogsModifier(): Collection
    {
        return $this->cuciMiglogsModifier;
    }

    public function addCuciMiglogsModifier(CuciMigLog $cuciMiglogsModifier): self
    {
        if (!$this->cuciMiglogsModifier->contains($cuciMiglogsModifier)) {
            $this->cuciMiglogsModifier[] = $cuciMiglogsModifier;
            $cuciMiglogsModifier->setModifiedBy($this);
        }

        return $this;
    }

    public function removeCuciMiglogsModifier(CuciMigLog $cuciMiglogsModifier): self
    {
        if ($this->cuciMiglogsModifier->removeElement($cuciMiglogsModifier)) {
            // set the owning side to null (unless already changed)
            if ($cuciMiglogsModifier->getModifiedBy() === $this) {
                $cuciMiglogsModifier->setModifiedBy(null);
            }
        }

        return $this;
    }

    public function getNiAdministration(): ?NiAdministration
    {
        return $this->niAdministration;
    }

    public function setNiAdministration(?NiAdministration $niAdministration): self
    {
        $this->niAdministration = $niAdministration;

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
            $niNineaproposition->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getCreatedBy() === $this) {
                $niNineaproposition->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiNineaproposition>
     */
    public function getNiNineapropositionsUpdatedBy(): Collection
    {
        return $this->niNineapropositionsUpdatedBy;
    }

    public function addNiNineapropositionsUpdatedBy(NiNineaproposition $niNineapropositionsUpdatedBy): self
    {
        if (!$this->niNineapropositionsUpdatedBy->contains($niNineapropositionsUpdatedBy)) {
            $this->niNineapropositionsUpdatedBy[] = $niNineapropositionsUpdatedBy;
            $niNineapropositionsUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeNiNineapropositionsUpdatedBy(NiNineaproposition $niNineapropositionsUpdatedBy): self
    {
        if ($this->niNineapropositionsUpdatedBy->removeElement($niNineapropositionsUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($niNineapropositionsUpdatedBy->getUpdatedBy() === $this) {
                $niNineapropositionsUpdatedBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BilanSmt>
     */
    public function getBilanSmts(): Collection
    {
        return $this->bilanSmts;
    }

    public function addBilanSmt(BilanSmt $bilanSmt): self
    {
        if (!$this->bilanSmts->contains($bilanSmt)) {
            $this->bilanSmts[] = $bilanSmt;
            $bilanSmt->setCreatedBy($this);
        }

        return $this;
    }

    public function removeBilanSmt(BilanSmt $bilanSmt): self
    {
        if ($this->bilanSmts->removeElement($bilanSmt)) {
            // set the owning side to null (unless already changed)
            if ($bilanSmt->getCreatedBy() === $this) {
                $bilanSmt->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BilanSmt>
     */
    public function getBilanSmtsUpdatedby(): Collection
    {
        return $this->bilanSmtsUpdatedby;
    }

    public function addBilanSmtsUpdatedby(BilanSmt $bilanSmtsUpdatedby): self
    {
        if (!$this->bilanSmtsUpdatedby->contains($bilanSmtsUpdatedby)) {
            $this->bilanSmtsUpdatedby[] = $bilanSmtsUpdatedby;
            $bilanSmtsUpdatedby->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeBilanSmtsUpdatedby(BilanSmt $bilanSmtsUpdatedby): self
    {
        if ($this->bilanSmtsUpdatedby->removeElement($bilanSmtsUpdatedby)) {
            // set the owning side to null (unless already changed)
            if ($bilanSmtsUpdatedby->getUpdatedBy() === $this) {
                $bilanSmtsUpdatedby->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ComptederesultatSmt>
     */
    public function getComptederesultatSmts(): Collection
    {
        return $this->comptederesultatSmts;
    }

    public function addComptederesultatSmt(ComptederesultatSmt $comptederesultatSmt): self
    {
        if (!$this->comptederesultatSmts->contains($comptederesultatSmt)) {
            $this->comptederesultatSmts[] = $comptederesultatSmt;
            $comptederesultatSmt->setCreatedBy($this);
        }

        return $this;
    }

    public function removeComptederesultatSmt(ComptederesultatSmt $comptederesultatSmt): self
    {
        if ($this->comptederesultatSmts->removeElement($comptederesultatSmt)) {
            // set the owning side to null (unless already changed)
            if ($comptederesultatSmt->getCreatedBy() === $this) {
                $comptederesultatSmt->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ComptederesultatSmt>
     */
    public function getComptederesultatSmtupdatedby(): Collection
    {
        return $this->comptederesultatSmtupdatedby;
    }

    public function addComptederesultatSmtupdatedby(ComptederesultatSmt $comptederesultatSmtupdatedby): self
    {
        if (!$this->comptederesultatSmtupdatedby->contains($comptederesultatSmtupdatedby)) {
            $this->comptederesultatSmtupdatedby[] = $comptederesultatSmtupdatedby;
            $comptederesultatSmtupdatedby->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeComptederesultatSmtupdatedby(ComptederesultatSmt $comptederesultatSmtupdatedby): self
    {
        if ($this->comptederesultatSmtupdatedby->removeElement($comptederesultatSmtupdatedby)) {
            // set the owning side to null (unless already changed)
            if ($comptederesultatSmtupdatedby->getUpdatedBy() === $this) {
                $comptederesultatSmtupdatedby->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompteDeResultats>
     */
    public function getCompteDeResultats(): Collection
    {
        return $this->compteDeResultats;
    }

    public function addCompteDeResultat(CompteDeResultats $compteDeResultat): self
    {
        if (!$this->compteDeResultats->contains($compteDeResultat)) {
            $this->compteDeResultats[] = $compteDeResultat;
            $compteDeResultat->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCompteDeResultat(CompteDeResultats $compteDeResultat): self
    {
        if ($this->compteDeResultats->removeElement($compteDeResultat)) {
            // set the owning side to null (unless already changed)
            if ($compteDeResultat->getCreatedBy() === $this) {
                $compteDeResultat->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuiviMaterielMobilier>
     */
    public function getModifiedBy(): Collection
    {
        return $this->modifiedBy;
    }

    public function addModifiedBy(SuiviMaterielMobilier $modifiedBy): self
    {
        if (!$this->modifiedBy->contains($modifiedBy)) {
            $this->modifiedBy[] = $modifiedBy;
            $modifiedBy->setCreatedBy($this);
        }

        return $this;
    }

    public function removeModifiedBy(SuiviMaterielMobilier $modifiedBy): self
    {
        if ($this->modifiedBy->removeElement($modifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($modifiedBy->getCreatedBy() === $this) {
                $modifiedBy->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuiviMaterielMobilier>
     */
    public function getSuiviMaterielMobiliers(): Collection
    {
        return $this->suiviMaterielMobiliers;
    }

    public function addSuiviMaterielMobilier(SuiviMaterielMobilier $suiviMaterielMobilier): self
    {
        if (!$this->suiviMaterielMobiliers->contains($suiviMaterielMobilier)) {
            $this->suiviMaterielMobiliers[] = $suiviMaterielMobilier;
            $suiviMaterielMobilier->setRelation($this);
        }

        return $this;
    }

    public function removeSuiviMaterielMobilier(SuiviMaterielMobilier $suiviMaterielMobilier): self
    {
        if ($this->suiviMaterielMobiliers->removeElement($suiviMaterielMobilier)) {
            // set the owning side to null (unless already changed)
            if ($suiviMaterielMobilier->getRelation() === $this) {
                $suiviMaterielMobilier->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuiviMaterielMobilier>
     */
    public function getSuiviMaterielMobiliersBy(): Collection
    {
        return $this->suiviMaterielMobiliersBy;
    }

    public function addSuiviMaterielMobiliersBy(SuiviMaterielMobilier $suiviMaterielMobiliersBy): self
    {
        if (!$this->suiviMaterielMobiliersBy->contains($suiviMaterielMobiliersBy)) {
            $this->suiviMaterielMobiliersBy[] = $suiviMaterielMobiliersBy;
            $suiviMaterielMobiliersBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeSuiviMaterielMobiliersBy(SuiviMaterielMobilier $suiviMaterielMobiliersBy): self
    {
        if ($this->suiviMaterielMobiliersBy->removeElement($suiviMaterielMobiliersBy)) {
            // set the owning side to null (unless already changed)
            if ($suiviMaterielMobiliersBy->getUpdatedBy() === $this) {
                $suiviMaterielMobiliersBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuiviMaterielMobilierCaution>
     */
    public function getSuiviMaterielMobilierCautions(): Collection
    {
        return $this->suiviMaterielMobilierCautions;
    }

    public function addSuiviMaterielMobilierCaution(SuiviMaterielMobilierCaution $suiviMaterielMobilierCaution): self
    {
        if (!$this->suiviMaterielMobilierCautions->contains($suiviMaterielMobilierCaution)) {
            $this->suiviMaterielMobilierCautions[] = $suiviMaterielMobilierCaution;
            $suiviMaterielMobilierCaution->setCreatedBy($this);
        }

        return $this;
    }

    public function removeSuiviMaterielMobilierCaution(SuiviMaterielMobilierCaution $suiviMaterielMobilierCaution): self
    {
        if ($this->suiviMaterielMobilierCautions->removeElement($suiviMaterielMobilierCaution)) {
            // set the owning side to null (unless already changed)
            if ($suiviMaterielMobilierCaution->getCreatedBy() === $this) {
                $suiviMaterielMobilierCaution->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SuiviMaterielMobilierCaution>
     */
    public function getSuiviMaterielMobiliersCautionsModifiedBy(): Collection
    {
        return $this->suiviMaterielMobiliersCautionsModifiedBy;
    }

    public function addSuiviMaterielMobiliersCautionsModifiedBy(SuiviMaterielMobilierCaution $suiviMaterielMobiliersCautionsModifiedBy): self
    {
        if (!$this->suiviMaterielMobiliersCautionsModifiedBy->contains($suiviMaterielMobiliersCautionsModifiedBy)) {
            $this->suiviMaterielMobiliersCautionsModifiedBy[] = $suiviMaterielMobiliersCautionsModifiedBy;
            $suiviMaterielMobiliersCautionsModifiedBy->setModifiedBy($this);
        }

        return $this;
    }

    public function removeSuiviMaterielMobiliersCautionsModifiedBy(SuiviMaterielMobilierCaution $suiviMaterielMobiliersCautionsModifiedBy): self
    {
        if ($this->suiviMaterielMobiliersCautionsModifiedBy->removeElement($suiviMaterielMobiliersCautionsModifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($suiviMaterielMobiliersCautionsModifiedBy->getModifiedBy() === $this) {
                $suiviMaterielMobiliersCautionsModifiedBy->setModifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatDesStocksSmt>
     */
    public function getEtatDesStocksSmts(): Collection
    {
        return $this->etatDesStocksSmts;
    }

    public function addEtatDesStocksSmt(EtatDesStocksSmt $etatDesStocksSmt): self
    {
        if (!$this->etatDesStocksSmts->contains($etatDesStocksSmt)) {
            $this->etatDesStocksSmts[] = $etatDesStocksSmt;
            $etatDesStocksSmt->setCreatedBy($this);
        }

        return $this;
    }

    public function removeEtatDesStocksSmt(EtatDesStocksSmt $etatDesStocksSmt): self
    {
        if ($this->etatDesStocksSmts->removeElement($etatDesStocksSmt)) {
            // set the owning side to null (unless already changed)
            if ($etatDesStocksSmt->getCreatedBy() === $this) {
                $etatDesStocksSmt->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EtatDesStocksSmt>
     */
    public function getEtatDesStocksSmtsUpdatedBy(): Collection
    {
        return $this->etatDesStocksSmtsUpdatedBy;
    }

    public function addEtatDesStocksSmtsUpdatedBy(EtatDesStocksSmt $etatDesStocksSmtsUpdatedBy): self
    {
        if (!$this->etatDesStocksSmtsUpdatedBy->contains($etatDesStocksSmtsUpdatedBy)) {
            $this->etatDesStocksSmtsUpdatedBy[] = $etatDesStocksSmtsUpdatedBy;
            $etatDesStocksSmtsUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeEtatDesStocksSmtsUpdatedBy(EtatDesStocksSmt $etatDesStocksSmtsUpdatedBy): self
    {
        if ($this->etatDesStocksSmtsUpdatedBy->removeElement($etatDesStocksSmtsUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($etatDesStocksSmtsUpdatedBy->getUpdatedBy() === $this) {
                $etatDesStocksSmtsUpdatedBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DettesCreancesSmt>
     */
    public function getDettesCreancesSmts(): Collection
    {
        return $this->dettesCreancesSmts;
    }

    public function addDettesCreancesSmt(DettesCreancesSmt $dettesCreancesSmt): self
    {
        if (!$this->dettesCreancesSmts->contains($dettesCreancesSmt)) {
            $this->dettesCreancesSmts[] = $dettesCreancesSmt;
            $dettesCreancesSmt->setCreatedBy($this);
        }

        return $this;
    }

    public function removeDettesCreancesSmt(DettesCreancesSmt $dettesCreancesSmt): self
    {
        if ($this->dettesCreancesSmts->removeElement($dettesCreancesSmt)) {
            // set the owning side to null (unless already changed)
            if ($dettesCreancesSmt->getCreatedBy() === $this) {
                $dettesCreancesSmt->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FluxDesTresoreries>
     */
    public function getFluxDesTresoreries(): Collection
    {
        return $this->fluxDesTresoreries;
    }

    public function addFluxDesTresorery(FluxDesTresoreries $fluxDesTresorery): self
    {
        if (!$this->fluxDesTresoreries->contains($fluxDesTresorery)) {
            $this->fluxDesTresoreries[] = $fluxDesTresorery;
            $fluxDesTresorery->setModifiedBy($this);
        }

        return $this;
    }

    public function removeFluxDesTresorery(FluxDesTresoreries $fluxDesTresorery): self
    {
        if ($this->fluxDesTresoreries->removeElement($fluxDesTresorery)) {
            // set the owning side to null (unless already changed)
            if ($fluxDesTresorery->getModifiedBy() === $this) {
                $fluxDesTresorery->setModifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AchatProduction>
     */
    public function getAchatProductions(): Collection
    {
        return $this->achatProductions;
    }

    public function addAchatProduction(AchatProduction $achatProduction): self
    {
        if (!$this->achatProductions->contains($achatProduction)) {
            $this->achatProductions[] = $achatProduction;
            $achatProduction->setCreatedBy($this);
        }

        return $this;
    }

    public function removeAchatProduction(AchatProduction $achatProduction): self
    {
        if ($this->achatProductions->removeElement($achatProduction)) {
            // set the owning side to null (unless already changed)
            if ($achatProduction->getCreatedBy() === $this) {
                $achatProduction->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AchatProduction>
     */
    public function getAchatProductionsUpdatedBy(): Collection
    {
        return $this->achatProductionsUpdatedBy;
    }

    public function addAchatProductionsUpdatedBy(AchatProduction $achatProductionsUpdatedBy): self
    {
        if (!$this->achatProductionsUpdatedBy->contains($achatProductionsUpdatedBy)) {
            $this->achatProductionsUpdatedBy[] = $achatProductionsUpdatedBy;
            $achatProductionsUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeAchatProductionsUpdatedBy(AchatProduction $achatProductionsUpdatedBy): self
    {
        if ($this->achatProductionsUpdatedBy->removeElement($achatProductionsUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($achatProductionsUpdatedBy->getUpdatedBy() === $this) {
                $achatProductionsUpdatedBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JournalTresorerie>
     */
    public function getJournalTresoreries(): Collection
    {
        return $this->journalTresoreries;
    }

    public function addJournalTresorery(JournalTresorerie $journalTresorery): self
    {
        if (!$this->journalTresoreries->contains($journalTresorery)) {
            $this->journalTresoreries[] = $journalTresorery;
            $journalTresorery->setCreatedBy($this);
        }

        return $this;
    }

    public function removeJournalTresorery(JournalTresorerie $journalTresorery): self
    {
        if ($this->journalTresoreries->removeElement($journalTresorery)) {
            // set the owning side to null (unless already changed)
            if ($journalTresorery->getCreatedBy() === $this) {
                $journalTresorery->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function isPremierConnexion(): ?bool
    {
        return $this->premierConnexion;
    }

    /**
     * @return Collection<int, JournalCreancesImpayeesSmt>
     */
    public function getJournalCreancesImpayeesSmts(): Collection
    {
        return $this->journalCreancesImpayeesSmts;
    }

    public function addJournalCreancesImpayeesSmt(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt): self
    {
        if (!$this->journalCreancesImpayeesSmts->contains($journalCreancesImpayeesSmt)) {
            $this->journalCreancesImpayeesSmts[] = $journalCreancesImpayeesSmt;
            $journalCreancesImpayeesSmt->setCreatedBy($this);
        }

        return $this;
    }

    public function removeJournalCreancesImpayeesSmt(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt): self
    {
        if ($this->journalCreancesImpayeesSmts->removeElement($journalCreancesImpayeesSmt)) {
            // set the owning side to null (unless already changed)
            if ($journalCreancesImpayeesSmt->getCreatedBy() === $this) {
                $journalCreancesImpayeesSmt->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JournalCreancesImpayeesSmt>
     */
    public function getJournalCreancesImpayeesSmtUpdatedBy(): Collection
    {
        return $this->journalCreancesImpayeesSmtUpdatedBy;
    }

    public function addJournalCreancesImpayeesSmtUpdatedBy(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmtUpdatedBy): self
    {
        if (!$this->journalCreancesImpayeesSmtUpdatedBy->contains($journalCreancesImpayeesSmtUpdatedBy)) {
            $this->journalCreancesImpayeesSmtUpdatedBy[] = $journalCreancesImpayeesSmtUpdatedBy;
            $journalCreancesImpayeesSmtUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeJournalCreancesImpayeesSmtUpdatedBy(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmtUpdatedBy): self
    {
        if ($this->journalCreancesImpayeesSmtUpdatedBy->removeElement($journalCreancesImpayeesSmtUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($journalCreancesImpayeesSmtUpdatedBy->getUpdatedBy() === $this) {
                $journalCreancesImpayeesSmtUpdatedBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JournalDettesPayerSmt>
     */
    public function getJournalDettesPayerSmts(): Collection
    {
        return $this->journalDettesPayerSmts;
    }

    public function addJournalDettesPayerSmt(JournalDettesPayerSmt $journalDettesPayerSmt): self
    {
        if (!$this->journalDettesPayerSmts->contains($journalDettesPayerSmt)) {
            $this->journalDettesPayerSmts[] = $journalDettesPayerSmt;
            $journalDettesPayerSmt->setCreatedBy($this);
        }

        return $this;
    }

    public function removeJournalDettesPayerSmt(JournalDettesPayerSmt $journalDettesPayerSmt): self
    {
        if ($this->journalDettesPayerSmts->removeElement($journalDettesPayerSmt)) {
            // set the owning side to null (unless already changed)
            if ($journalDettesPayerSmt->getCreatedBy() === $this) {
                $journalDettesPayerSmt->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JournalDettesPayerSmt>
     */
    public function getJournalDettesPayerSmtsUpdatedBy(): Collection
    {
        return $this->journalDettesPayerSmtsUpdatedBy;
    }

    public function addJournalDettesPayerSmtsUpdatedBy(JournalDettesPayerSmt $journalDettesPayerSmtsUpdatedBy): self
    {
        if (!$this->journalDettesPayerSmtsUpdatedBy->contains($journalDettesPayerSmtsUpdatedBy)) {
            $this->journalDettesPayerSmtsUpdatedBy[] = $journalDettesPayerSmtsUpdatedBy;
            $journalDettesPayerSmtsUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeJournalDettesPayerSmtsUpdatedBy(JournalDettesPayerSmt $journalDettesPayerSmtsUpdatedBy): self
    {
        if ($this->journalDettesPayerSmtsUpdatedBy->removeElement($journalDettesPayerSmtsUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($journalDettesPayerSmtsUpdatedBy->getUpdatedBy() === $this) {
                $journalDettesPayerSmtsUpdatedBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CuciImmoPlus>
     */
    public function getCuciImmoPlusesBy(): Collection
    {
        return $this->cuciImmoPlusesBy;
    }

    public function addCuciImmoPlusesBy(CuciImmoPlus $cuciImmoPlusesBy): self
    {
        if (!$this->cuciImmoPlusesBy->contains($cuciImmoPlusesBy)) {
            $this->cuciImmoPlusesBy[] = $cuciImmoPlusesBy;
            $cuciImmoPlusesBy->setModifiedBy($this);
        }

        return $this;
    }

    public function removeCuciImmoPlusesBy(CuciImmoPlus $cuciImmoPlusesBy): self
    {
        if ($this->cuciImmoPlusesBy->removeElement($cuciImmoPlusesBy)) {
            // set the owning side to null (unless already changed)
            if ($cuciImmoPlusesBy->getModifiedBy() === $this) {
                $cuciImmoPlusesBy->setModifiedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductionDeExercice>
     */
    public function getProductionDeExercicesUpBy(): Collection
    {
        return $this->productionDeExercicesUpBy;
    }

    public function addProductionDeExercicesUpBy(ProductionDeExercice $productionDeExercicesUpBy): self
    {
        if (!$this->productionDeExercicesUpBy->contains($productionDeExercicesUpBy)) {
            $this->productionDeExercicesUpBy[] = $productionDeExercicesUpBy;
            $productionDeExercicesUpBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeProductionDeExercicesUpBy(ProductionDeExercice $productionDeExercicesUpBy): self
    {
        if ($this->productionDeExercicesUpBy->removeElement($productionDeExercicesUpBy)) {
            // set the owning side to null (unless already changed)
            if ($productionDeExercicesUpBy->getUpdatedBy() === $this) {
                $productionDeExercicesUpBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Effectifs>
     */
    public function getEffectifsUpBy(): Collection
    {
        return $this->effectifsUpBy;
    }

    public function addEffectifsUpBy(Effectifs $effectifsUpBy): self
    {
        if (!$this->effectifsUpBy->contains($effectifsUpBy)) {
            $this->effectifsUpBy[] = $effectifsUpBy;
            $effectifsUpBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeEffectifsUpBy(Effectifs $effectifsUpBy): self
    {
        if ($this->effectifsUpBy->removeElement($effectifsUpBy)) {
            // set the owning side to null (unless already changed)
            if ($effectifsUpBy->getUpdatedBy() === $this) {
                $effectifsUpBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompteDeResultats>
     */
    public function getCompteDeResultatsUpBy(): Collection
    {
        return $this->compteDeResultatsUpBy;
    }

    public function addCompteDeResultatsUpBy(CompteDeResultats $compteDeResultatsUpBy): self
    {
        if (!$this->compteDeResultatsUpBy->contains($compteDeResultatsUpBy)) {
            $this->compteDeResultatsUpBy[] = $compteDeResultatsUpBy;
            $compteDeResultatsUpBy->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCompteDeResultatsUpBy(CompteDeResultats $compteDeResultatsUpBy): self
    {
        if ($this->compteDeResultatsUpBy->removeElement($compteDeResultatsUpBy)) {
            // set the owning side to null (unless already changed)
            if ($compteDeResultatsUpBy->getCreatedBy() === $this) {
                $compteDeResultatsUpBy->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FluxDesTresoreries>
     */
    public function getFluxDesTresoreriesUpBy(): Collection
    {
        return $this->fluxDesTresoreriesUpBy;
    }

    public function addFluxDesTresoreriesUpBy(FluxDesTresoreries $fluxDesTresoreriesUpBy): self
    {
        if (!$this->fluxDesTresoreriesUpBy->contains($fluxDesTresoreriesUpBy)) {
            $this->fluxDesTresoreriesUpBy[] = $fluxDesTresoreriesUpBy;
            $fluxDesTresoreriesUpBy->setEditedBy($this);
        }

        return $this;
    }

    public function removeFluxDesTresoreriesUpBy(FluxDesTresoreries $fluxDesTresoreriesUpBy): self
    {
        if ($this->fluxDesTresoreriesUpBy->removeElement($fluxDesTresoreriesUpBy)) {
            // set the owning side to null (unless already changed)
            if ($fluxDesTresoreriesUpBy->getEditedBy() === $this) {
                $fluxDesTresoreriesUpBy->setEditedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NINinea>
     */
    public function getNINineaModifiedBy(): Collection
    {
        return $this->nINineaModifiedBy;
    }

    public function addNINineaModifiedBy(NINinea $nINineaModifiedBy): self
    {
        if (!$this->nINineaModifiedBy->contains($nINineaModifiedBy)) {
            $this->nINineaModifiedBy[] = $nINineaModifiedBy;
            $nINineaModifiedBy->setModifiedBy($this);
        }

        return $this;
    }

    public function removeNINineaModifiedBy(NINinea $nINineaModifiedBy): self
    {
        if ($this->nINineaModifiedBy->removeElement($nINineaModifiedBy)) {
            // set the owning side to null (unless already changed)
            if ($nINineaModifiedBy->getModifiedBy() === $this) {
                $nINineaModifiedBy->setModifiedBy(null);
            }
        }

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
            $niCessation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNiCessation(NiCessation $niCessation): self
    {
        if ($this->niCessations->removeElement($niCessation)) {
            // set the owning side to null (unless already changed)
            if ($niCessation->getCreatedBy() === $this) {
                $niCessation->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiCessation>
     */
    public function getNiCessationeditbys(): Collection
    {
        return $this->niCessationeditbys;
    }

    public function addNiCessationeditby(NiCessation $niCessationeditby): self
    {
        if (!$this->niCessationeditbys->contains($niCessationeditby)) {
            $this->niCessationeditbys[] = $niCessationeditby;
            $niCessationeditby->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeNiCessationeditby(NiCessation $niCessationeditby): self
    {
        if ($this->niCessationeditbys->removeElement($niCessationeditby)) {
            // set the owning side to null (unless already changed)
            if ($niCessationeditby->getUpdatedBy() === $this) {
                $niCessationeditby->setUpdatedBy(null);
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
            $nireactivation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNireactivation(Nireactivation $nireactivation): self
    {
        if ($this->nireactivations->removeElement($nireactivation)) {
            // set the owning side to null (unless already changed)
            if ($nireactivation->getCreatedBy() === $this) {
                $nireactivation->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Nireactivation>
     */
    public function getNireactivationedits(): Collection
    {
        return $this->nireactivationedits;
    }

    public function addNireactivationedit(Nireactivation $nireactivationedit): self
    {
        if (!$this->nireactivationedits->contains($nireactivationedit)) {
            $this->nireactivationedits[] = $nireactivationedit;
            $nireactivationedit->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeNireactivationedit(Nireactivation $nireactivationedit): self
    {
        if ($this->nireactivationedits->removeElement($nireactivationedit)) {
            // set the owning side to null (unless already changed)
            if ($nireactivationedit->getUpdatedBy() === $this) {
                $nireactivationedit->setUpdatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NinJourFerier>
     */
    public function getNinJourFeriers(): Collection
    {
        return $this->ninJourFeriers;
    }

    public function addNinJourFerier(NinJourFerier $ninJourFerier): self
    {
        if (!$this->ninJourFeriers->contains($ninJourFerier)) {
            $this->ninJourFeriers[] = $ninJourFerier;
            $ninJourFerier->setCreatedBy($this);
        }

        return $this;
    }

    public function removeNinJourFerier(NinJourFerier $ninJourFerier): self
    {
        if ($this->ninJourFeriers->removeElement($ninJourFerier)) {
            // set the owning side to null (unless already changed)
            if ($ninJourFerier->getCreatedBy() === $this) {
                $ninJourFerier->setCreatedBy(null);
            }
        }

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
            $historyNiActivite->setCreatedBy($this);
        }

        return $this;
    }

    public function removeHistoryNiActivite(HistoryNiActivite $historyNiActivite): self
    {
        if ($this->historyNiActivites->removeElement($historyNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActivite->getCreatedBy() === $this) {
                $historyNiActivite->setCreatedBy(null);
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
            $historyNiActiviteEconomique->setCreateBy($this);
        }

        return $this;
    }

    public function removeHistoryNiActiviteEconomique(HistoryNiActiviteEconomique $historyNiActiviteEconomique): self
    {
        if ($this->historyNiActiviteEconomiques->removeElement($historyNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActiviteEconomique->getCreateBy() === $this) {
                $historyNiActiviteEconomique->setCreateBy(null);
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
            $historyNiDirigeant->setCreatedBy($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getCreatedBy() === $this) {
                $historyNiDirigeant->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiPersonne>
     */
    public function getHistoryNiPersonnes(): Collection
    {
        return $this->historyNiPersonnes;
    }

    public function addHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if (!$this->historyNiPersonnes->contains($historyNiPersonne)) {
            $this->historyNiPersonnes[] = $historyNiPersonne;
            $historyNiPersonne->setCreatedBy($this);
        }

        return $this;
    }

    public function removeHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if ($this->historyNiPersonnes->removeElement($historyNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($historyNiPersonne->getCreatedBy() === $this) {
                $historyNiPersonne->setCreatedBy(null);
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
            $historyNiNineaproposition->setCreatedBy($this);
        }

        return $this;
    }

    public function removeHistoryNiNineaproposition(HistoryNiNineaproposition $historyNiNineaproposition): self
    {
        if ($this->historyNiNineapropositions->removeElement($historyNiNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($historyNiNineaproposition->getCreatedBy() === $this) {
                $historyNiNineaproposition->setCreatedBy(null);
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
            $historyNINinea->setCreatedBy($this);
        }

        return $this;
    }

    public function removeHistoryNINinea(HistoryNINinea $historyNINinea): self
    {
        if ($this->historyNINineas->removeElement($historyNINinea)) {
            // set the owning side to null (unless already changed)
            if ($historyNINinea->getCreatedBy() === $this) {
                $historyNINinea->setCreatedBy(null);
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
            $tempNiActivite->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNiActivite(TempNiActivite $tempNiActivite): self
    {
        if ($this->tempNiActivites->removeElement($tempNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActivite->getCreatedBy() === $this) {
                $tempNiActivite->setCreatedBy(null);
            }
        }

        return $this;
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
            $tempNiActiviteEconomique->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNiActiviteEconomique(TempNiActiviteEconomique $tempNiActiviteEconomique): self
    {
        if ($this->tempNiActiviteEconomiques->removeElement($tempNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($tempNiActiviteEconomique->getCreatedBy() === $this) {
                $tempNiActiviteEconomique->setCreatedBy(null);
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
            $tempNiCessation->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNiCessation(TempNiCessation $tempNiCessation): self
    {
        if ($this->tempNiCessations->removeElement($tempNiCessation)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCessation->getCreatedBy() === $this) {
                $tempNiCessation->setCreatedBy(null);
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
            $tempNiCoordonnee->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if ($this->tempNiCoordonnees->removeElement($tempNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCoordonnee->getCreatedBy() === $this) {
                $tempNiCoordonnee->setCreatedBy(null);
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
            $tempNiDirigeant->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getCreatedBy() === $this) {
                $tempNiDirigeant->setCreatedBy(null);
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
            $tempNiPersonne->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getCreatedBy() === $this) {
                $tempNiPersonne->setCreatedBy(null);
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
            $tempNINinea->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTempNINinea(TempNINinea $tempNINinea): self
    {
        if ($this->tempNINineas->removeElement($tempNINinea)) {
            // set the owning side to null (unless already changed)
            if ($tempNINinea->getCreatedBy() === $this) {
                $tempNINinea->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeModification>
     */
    public function getDemandeModifications(): Collection
    {
        return $this->demandeModifications;
    }

    public function addDemandeModification(DemandeModification $demandeModification): self
    {
        if (!$this->demandeModifications->contains($demandeModification)) {
            $this->demandeModifications[] = $demandeModification;
            $demandeModification->setCreatedBy($this);
        }

        return $this;
    }

    public function removeDemandeModification(DemandeModification $demandeModification): self
    {
        if ($this->demandeModifications->removeElement($demandeModification)) {
            // set the owning side to null (unless already changed)
            if ($demandeModification->getCreatedBy() === $this) {
                $demandeModification->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemandeModification>
     */
    public function getDemandeUpdatedBy(): Collection
    {
        return $this->demandeUpdatedBy;
    }

    public function addDemandeUpdatedBy(DemandeModification $demandeUpdatedBy): self
    {
        if (!$this->demandeUpdatedBy->contains($demandeUpdatedBy)) {
            $this->demandeUpdatedBy[] = $demandeUpdatedBy;
            $demandeUpdatedBy->setUpdatedBy($this);
        }

        return $this;
    }

    public function removeDemandeUpdatedBy(DemandeModification $demandeUpdatedBy): self
    {
        if ($this->demandeUpdatedBy->removeElement($demandeUpdatedBy)) {
            // set the owning side to null (unless already changed)
            if ($demandeUpdatedBy->getUpdatedBy() === $this) {
                $demandeUpdatedBy->setUpdatedBy(null);
            }
        }

        return $this;
    }

    

   
   


}