<?php

namespace App\Entity;

use App\Repository\HistoryNiNineapropositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoryNiNineapropositionRepository::class)
 */
class HistoryNiNineaproposition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

        /**
     * @ORM\ManyToOne(targetEntity=HistoryNiPersonne::class, inversedBy="niNineapropositions")
     */
    private $historyNiPersonne;

    
    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActivite::class, mappedBy="niNineaproposition")
     */
    private $historyNiActivites;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiActiviteEconomique::class, mappedBy="niNineaproposition")
     */
    private $historyNiActiviteEconomiques;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="ninNineaProposition")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNinproduits::class, mappedBy="nineaproposition")
     */
    private $historyNinproduits;

    /**
     * @ORM\ManyToOne(targetEntity=NiStatut::class, inversedBy="historyNiNineapropositions")
     */
    private $ninStatut;

    /**
     * @ORM\ManyToOne(targetEntity=NiFormejuridique::class, inversedBy="historyNiNineapropositions")
     */
    private $ninFormejuridique;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historyNiNineapropositions")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="historyNiNineapropositions")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ninRegcom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninNinea;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninCreation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ninEnseigne;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $ninEtat;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninNineamere;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $ninNumetab;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninmajdate;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninnumerodemande;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $nincreationninea;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninSiglemere;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninRemarque;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDatreg;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ninlock;

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
     * @ORM\Column(type="string", length=255, nullable=true)
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
     * @ORM\OneToMany(targetEntity=HistoryNiCoordonnees::class, mappedBy="historyNiNineaproposition")
     */
    private $niCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNINinea::class, mappedBy="historyNiNineaproposition")
     */
    private $coordonnees;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $ninSigle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninMisajour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninRaison;

    /**
     * @ORM\ManyToOne(targetEntity=NiAdministration::class, inversedBy="historyNiNineapropositions")
     */
    private $ninAdministration;

    public function __construct()
    {
        $this->niCoordonnees = new ArrayCollection();
        $this->coordonnees = new ArrayCollection();
        $this->historyNiActivites = new ArrayCollection();
        $this->historyNiActiviteEconomiques = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNinproduits = new ArrayCollection();
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

    public function getNinStatut(): ?NiStatut
    {
        return $this->ninStatut;
    }

    public function setNinStatut(?NiStatut $ninStatut): self
    {
        $this->ninStatut = $ninStatut;

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

    public function getNinCreation(): ?\DateTimeInterface
    {
        return $this->ninCreation;
    }

    public function setNinCreation(?\DateTimeInterface $ninCreation): self
    {
        $this->ninCreation = $ninCreation;

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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

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

    /**
     * @return Collection<int, HistoryNiCoordonnees>
     */
    public function getNiCoordonnees(): Collection
    {
        return $this->niCoordonnees;
    }

    public function addNiCoordonnee(HistoryNiCoordonnees $niCoordonnee): self
    {
        if (!$this->niCoordonnees->contains($niCoordonnee)) {
            $this->niCoordonnees[] = $niCoordonnee;
            $niCoordonnee->setHistoryNiNineaproposition($this);
        }

        return $this;
    }

    public function removeNiCoordonnee(HistoryNiCoordonnees $niCoordonnee): self
    {
        if ($this->niCoordonnees->removeElement($niCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($niCoordonnee->getHistoryNiNineaproposition() === $this) {
                $niCoordonnee->setHistoryNiNineaproposition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNINinea>
     */
    public function getCoordonnees(): Collection
    {
        return $this->coordonnees;
    }

    public function addCoordonnee(HistoryNINinea $coordonnee): self
    {
        if (!$this->coordonnees->contains($coordonnee)) {
            $this->coordonnees[] = $coordonnee;
            $coordonnee->setHistoryNiNineaproposition($this);
        }

        return $this;
    }

    public function removeCoordonnee(HistoryNINinea $coordonnee): self
    {
        if ($this->coordonnees->removeElement($coordonnee)) {
            // set the owning side to null (unless already changed)
            if ($coordonnee->getHistoryNiNineaproposition() === $this) {
                $coordonnee->setHistoryNiNineaproposition(null);
            }
        }

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

    public function getNinMisajour(): ?\DateTimeInterface
    {
        return $this->ninMisajour;
    }

    public function setNinMisajour(?\DateTimeInterface $ninMisajour): self
    {
        $this->ninMisajour = $ninMisajour;

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

    public function getNinAdministration(): ?NiAdministration
    {
        return $this->ninAdministration;
    }

    public function setNinAdministration(?NiAdministration $ninAdministration): self
    {
        $this->ninAdministration = $ninAdministration;

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
            $historyNiActivite->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeHistoryNiActivite(HistoryNiActivite $historyNiActivite): self
    {
        if ($this->historyNiActivites->removeElement($historyNiActivite)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActivite->getNiNineaproposition() === $this) {
                $historyNiActivite->setNiNineaproposition(null);
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
            $historyNiActiviteEconomique->setNiNineaproposition($this);
        }

        return $this;
    }

    public function removeHistoryNiActiviteEconomique(HistoryNiActiviteEconomique $historyNiActiviteEconomique): self
    {
        if ($this->historyNiActiviteEconomiques->removeElement($historyNiActiviteEconomique)) {
            // set the owning side to null (unless already changed)
            if ($historyNiActiviteEconomique->getNiNineaproposition() === $this) {
                $historyNiActiviteEconomique->setNiNineaproposition(null);
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
            $historyNiDirigeant->setNinNineaProposition($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNinNineaProposition() === $this) {
                $historyNiDirigeant->setNinNineaProposition(null);
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
            $historyNinproduit->setNineaproposition($this);
        }

        return $this;
    }

    public function removeHistoryNinproduit(HistoryNinproduits $historyNinproduit): self
    {
        if ($this->historyNinproduits->removeElement($historyNinproduit)) {
            // set the owning side to null (unless already changed)
            if ($historyNinproduit->getNineaproposition() === $this) {
                $historyNinproduit->setNineaproposition(null);
            }
        }

        return $this;
    }

}
