<?php

namespace App\Entity;

use App\Repository\NiNineapropositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NiNineapropositionRepository::class)
 * @Gedmo\Loggable
 */
class NiNineaproposition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column( type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\Length(max=250,maxMessage="MaxErrorMessage")
     */
    private $ninRaison;


    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max=50,maxMessage="MaxErrorMessage")
     */
    private $ninRegcom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20,maxMessage="MaxErrorMessage")
     */
    private $ninNinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninMisajour;



    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20,maxMessage="MaxErrorMessage")
     */
    private $ninSigle;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     */
    private $ninCreation;



    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Versioned
     */
    private $ninEnseigne;



    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninEtat;




    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20,maxMessage="MaxErrorMessage")
     */
    private $ninNineamere;


    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     * @Assert\Length(max=3,maxMessage="MaxErrorMessage")
     */
    private $ninNumetab;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninmajdate;



    /**
     * @ORM\Column(type="string", length=20, nullable=true, name="ninNumeroDemande")
     */
    private $ninnumerodemande;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $nincreationninea;




    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20,maxMessage="MaxErrorMessage")
     */
    private $ninSiglemere;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\Length(max=200,maxMessage="MaxErrorMessage")
     */
    private $ninRemarque;



    public $ninFormeUnite;



    /**
     * @ORM\ManyToOne(targetEntity=NiStatut::class, inversedBy="niNineapropositions")
     */
    private $ninStatut;


    /**
     * @ORM\ManyToOne(targetEntity=NiAdministration::class, inversedBy="niNineapropositions")
     */
    private $ninAdministration;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatreg;


    /**
     * @ORM\ManyToOne(targetEntity=NiFormejuridique::class, inversedBy="niNineapropositions")
     */
    private $ninFormejuridique;



    /**
     * @ORM\OneToMany(targetEntity=NiCoordonnees::class, mappedBy="ninNinea")
     */
    private $niCoordonnees;


    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Length(max=20,maxMessage="MaxErrorMessage")
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=NiCoordonnees::class, mappedBy="niNineaproposition")
     */
    private $coordonnees;

     /**
     * @ORM\OneToMany(targetEntity=NiActivite::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="niNineaproposition")
     */
    private $ninActivites;

    

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class,fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="ninNineaProposition")
     */
    private $ninDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=NiActiviteEconomique::class, mappedBy="niNineaproposition")
     */
    private $niActiviteEconomiques;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="niNineapropositions")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="niNineapropositionsUpdatedBy")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ninlock ;

    /**
     * @ORM\OneToMany(targetEntity=Ninproduits::class, mappedBy="nineaproposition")
     */
    private $ninproduits;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $niLibelleactiviteglobale;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninTitrefoncier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninAgrement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninArrete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninRecepisse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninAccord;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninBordereau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninBail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Versioned
     */
    private $ninPermisoccuper;

    /**
     * @ORM\ManyToOne(targetEntity=NiPersonne::class, inversedBy="niNineapropositions")
     */
    private $niPersonne;

    /**
     * @ORM\ManyToOne(targetEntity=NinTypedocuments::class, inversedBy="niNineapropositions")
     */
    private $niTypedocument;


    public function __construct()
    {

        $this->ninlock=false;
        $this->ninCreation=new \DateTime();
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->niCoordonnees = new ArrayCollection();
        $this->coordonnees = new ArrayCollection();
        $this->ninActivites = new ArrayCollection();
        $this->ninDirigeants = new ArrayCollection();
        $this->niActiviteEconomiques = new ArrayCollection();
        $this->ninproduits = new ArrayCollection();

    }


    public function __toString()
    {
        return $this->ninRaison;
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



    /**public function getNinActivite(): ?string
    {
        return $this->ninActivite;
    }

    public function setNinActivite(?string $ninActivite): self
    {
        $this->ninActivite = $ninActivite;

        return $this;
    }*/

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



   /**public function getNinCuci(): ?string
    {
        return $this->ninCuci;
    }

    public function setNinCuci(?string $ninCuci): self
    {
        $this->ninCuci = $ninCuci;

        return $this;
    }*/

    public function getNinEtat(): ?string
    {
        return $this->ninEtat;
    }

    public function setNinEtat(?string $ninEtat): self
    {
        $this->ninEtat = $ninEtat;

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

    public function getNinmajdate(): ?\DateTimeInterface
    {
        return $this->ninmajdate;
    }

    public function setNinmajdate(?\DateTimeInterface $ninmajdate): self
    {
        $this->ninmajdate = $ninmajdate;

        return $this;
    }


    public function getNinnumerodemande(): ?string
    {
        return $this->ninnumerodemande;
    }

    public function setNinnumerodemande(?string $ninnumerodemande): self
    {
        $this->ninnumerodemande = $ninnumerodemande;

        return $this;
    }


    public function getNincreationninea(): ?\DateTimeInterface
    {
        return $this->nincreationninea;
    }

    public function setNincreationninea(?\DateTimeInterface $nincreationninea): self
    {
        $this->nincreationninea = $nincreationninea;

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



    public function getNinStatut(): ?NiStatut
    {
        return $this->ninStatut;
    }

    public function setNinStatut(?NiStatut $ninStatut): self
    {
        $this->ninStatut = $ninStatut;

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

   

  



    public function getNinFormejuridique(): ?NiFormejuridique
    {
        return $this->ninFormejuridique;
    }

    public function setNinFormejuridique(?NiFormejuridique $ninFormejuridique): self
    {
        $this->ninFormejuridique = $ninFormejuridique;

        return $this;
    }

    public function getNinFormeUnite()
    {
        return $this->ninFormeUnite;
    }

    public function setNinFormeUnite( $ninFormeUnite)
    {
        $this->ninFormeUnite = $ninFormeUnite;

        return $this;
    }

    /**public function getNinNumeroBordereau(): ?string
    {
        return $this->ninNumeroBordereau;
    }

    public function setNinNumeroBordereau(?string $ninNumeroBordereau): self
    {
        $this->ninNumeroBordereau = $ninNumeroBordereau;

        return $this;
    }*/



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

    public function getNinEnseigne(): ?string
    {
        return $this->ninEnseigne;
    }

    public function setNinEnseigne(?string $ninEnseigne): self
    {
        $this->ninEnseigne = $ninEnseigne;

        return $this;
    }

    public function getNinRemarque(): ?string
    {
        return $this->ninRemarque;
    }

    public function setNinRemarque(?string $ninRemarque): self
    {
        $this->ninRemarque = $ninRemarque;

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

   




    


/**
     * @return Collection|NiDirigeant[]
     */
    public function getNinDirigeants(): Collection
    {
        return $this->ninDirigeants;
    }

    public function addNinDirigeant(NiDirigeant $ninDirigeant): self
    {
        if (!$this->ninDirigeants->contains($ninDirigeant)) {
            $this->ninDirigeants[] = $ninDirigeant;
            $ninDirigeant->setninNineaproposition($this);
        }

        return $this;
    }

    public function removeDirigeant(NiDirigeant $ninDirigeant): self
    {
        if ($this->ninDirigeants->removeElement($ninDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($ninDirigeant->getNinNineaProposition() === $this) {
                $ninDirigeant->setNinNineaProposition(null);
            }
        }

        return $this;
    }


/**
     * @return Collection|niActivite[]
     */
    public function getNinActivites(): Collection
    {
        return $this->ninActivites;
    }

    public function addNinActivite(NiActivite $ninActivite): self
    {
        if (!$this->ninActivites->contains($ninActivite)) {
            $this->ninActivites[] = $ninActivite;
            $ninActivite->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeActivite(NiActivite $ninActivite): self
    {
        if ($this->ninActivites->removeElement($ninActivite)) {
            // set the owning side to null (unless already changed)
            if ($ninActivite->getNiNineaproposition() === $this) {
                $ninActivite->setNiNineaproposition(null);
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

    public function removeNinDirigeant(NiDirigeant $ninDirigeant): self
    {
        if ($this->ninDirigeants->removeElement($ninDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($ninDirigeant->getNinNineaProposition() === $this) {
                $ninDirigeant->setNinNineaProposition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiCoordonnees>
     */
    public function getCoordonnees(): Collection
    {
        return $this->coordonnees;
    }

    public function addCoordonnee(NiCoordonnees $coordonnee): self
    {
        if (!$this->coordonnees->contains($coordonnee)) {
            $this->coordonnees[] = $coordonnee;
            $coordonnee->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeCoordonnee(NiCoordonnees $coordonnee): self
    {
        if ($this->coordonnees->removeElement($coordonnee)) {
            // set the owning side to null (unless already changed)
            if ($coordonnee->getNiNineaproposition() === $this) {
                $coordonnee->setNiNineaproposition(null);
            }
        }

        return $this;
    }

    public function removeNinActivite(NiActivite $ninActivite): self
    {
        if ($this->ninActivites->removeElement($ninActivite)) {
            // set the owning side to null (unless already changed)
            if ($ninActivite->getNiNineaproposition() === $this) {
                $ninActivite->setNiNineaproposition(null);
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
            $niActiviteEconomique->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeNiActiviteEconomique(NiActiviteEconomique $niActiviteEconomique): self
    {
        if ($this->niActiviteEconomiques->removeElement($niActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($niActiviteEconomique->getNiNineaproposition() === $this) {
                $niActiviteEconomique->setNiNineaproposition(null);
            }
        }

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

    public function getNinlock(): ?bool
    {
        return $this->ninlock;
    }

    public function setNinlock(?bool $ninlock): self
    {
        $this->ninlock = $ninlock;

        return $this;
    }

    /**
     * @return Collection<int, Ninproduits>
     */
    public function getNinproduits(): Collection
    {
        return $this->ninproduits;
    }

    public function addNinproduits(Ninproduits $ninproduit): self
    {
        if (!$this->ninproduits->contains($ninproduit)) {
            $this->ninproduits[] = $ninproduit;
            $ninproduit->setNineaproposition($this);
        }

        return $this;
    }

    public function removeNinproduits(Ninproduits $ninproduit): self
    {
        if ($this->ninproduits->removeElement($ninproduit)) {
            // set the owning side to null (unless already changed)
            if ($ninproduit->getNineaproposition() === $this) {
                $ninproduit->setNineaproposition(null);
            }
        }

        return $this;
    }

    public function addNinproduit(Ninproduits $ninproduit): self
    {
        if (!$this->ninproduits->contains($ninproduit)) {
            $this->ninproduits[] = $ninproduit;
            $ninproduit->setNineaproposition($this);
        }

        return $this;
    }

    public function removeNinproduit(Ninproduits $ninproduit): self
    {
        if ($this->ninproduits->removeElement($ninproduit)) {
            // set the owning side to null (unless already changed)
            if ($ninproduit->getNineaproposition() === $this) {
                $ninproduit->setNineaproposition(null);
            }
        }

        return $this;
    }

    public function isNinlock(): ?bool
    {
        return $this->ninlock;
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

    public function getNiPersonne(): ?NiPersonne
    {
        return $this->niPersonne;
    }

    public function setNiPersonne(?NiPersonne $niPersonne): self
    {
        $this->niPersonne = $niPersonne;

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