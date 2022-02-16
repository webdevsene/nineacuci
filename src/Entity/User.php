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


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`utilisateur`")
 * @UniqueEntity(fields={"username"}, message="Il existe déjà un compte avec ce nom d'utilisateur.")
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
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
     */
    private $nom;


    /**
     * @ORM\Column(type="date", nullable=true)
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
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
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
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut etre vide.")
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
     * @ORM\OneToMany(targetEntity=Bilan::class, mappedBy="modifiedBy")
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

    

   
   


}
