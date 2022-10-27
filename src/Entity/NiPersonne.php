<?php

namespace App\Entity;

use App\Repository\NiPersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;

/**
 * @ORM\Entity(repositoryClass=NiPersonneRepository::class)
 */
class NiPersonne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max=100,maxMessage="MaxErrorMessage")
     */
    private $ninNom;

    /**
     * @ORM\Column(type="string", length=100 , nullable=true)
     *  @Assert\Length(max=100,maxMessage="MaxErrorMessage")
     */
    private $ninPrenom;

   
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ninDateNaissance;

    /**
     * @ORM\Column(type="string",  nullable=true)
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
     *  @Assert\Length(max=100,maxMessage="MaxErrorMessage")
     */
    private $ninSigle;



    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $ninRaison;


    /**
     * @ORM\ManyToOne(targetEntity=NiSexe::class, inversedBy="niPersonnes")
     */
    private $ninSexe;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=NiCivilite::class, inversedBy="niPersonnes")
     */
    private $civilite;

    /**
     * @ORM\ManyToOne(targetEntity=Pays::class, inversedBy="niPersonnes")
     */
    private $nationalite;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="niPersonnes")
     */
    private $created_by;

  
    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="niPersonnes")
     */
    private $ninQvh;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $ninTelephone;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     *  @Assert\Length(max=200,maxMessage="MaxErrorMessage")
     */
    private $ninEmailPersonnel;

    /**
     * @ORM\ManyToOne(targetEntity=NiTypevoie::class, inversedBy="niPersonnes")
     */
    private $ninTypevoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Assert\Length(max=255,maxMessage="MaxErrorMessage")
     */
    private $ninVoie;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  @Assert\Length(max=5,maxMessage="MaxErrorMessage")
     */
    private $numVoie;

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="niPersonne")
     * 
     */
    private $ninNinea;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="niPersonne")
     */
    private $niNineapropositions;

    public function __construct()
    {
        
        $this->created_at=new \DateTime();
        $this->updated_at=new \DateTime();
        $this->ninNinea = new ArrayCollection();
        $this->niNineapropositions = new ArrayCollection();
        
    }

    public function __toString()
    {
        return $this->ninPrenom;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinNom(): ?string
    {
        return $this->ninNom;
    }

    public function setNinNom(string $ninNom): self
    {
        $this->ninNom = $ninNom;

        return $this;
    }

    public function getNinPrenom(): ?string
    {
        return $this->ninPrenom;
    }

    public function setNinPrenom(string $ninPrenom): self
    {
        $this->ninPrenom = $ninPrenom;

        return $this;
    }
  

    public function getNinDateNaissance(): ?\DateTimeInterface
    {
        return $this->ninDateNaissance;
    }

    public function setNinDateNaissance(\DateTimeInterface $ninDateNaissance): self
    {
        $this->ninDateNaissance = $ninDateNaissance;

        return $this;
    }

    public function getNinLieuNaissance(): ?string
    {
        return $this->ninLieuNaissance;
    }

    public function setNinLieuNaissance(string $ninLieuNaissance): self
    {
        $this->ninLieuNaissance = $ninLieuNaissance;

        return $this;
    }


    public function getNinCNI(): ?string
    {
        return $this->ninCNI;
    }

    public function setNinCNI(string $ninCNI): self
    {
        $this->ninCNI = $ninCNI;

        return $this;
    }

    public function getNinDateCNI(): ?\DateTimeInterface
    {
        return $this->ninDateCNI;
    }

    public function setNinDateCNI(\DateTimeInterface $ninDateCNI): self
    {
        $this->ninDateCNI = $ninDateCNI;

        return $this;
    }
   

    public function getNinSigle(): ?string
    {
        return $this->ninSigle;
    }

    public function setNinSigle(string $ninSigle): self
    {
        $this->ninSigle = $ninSigle;

        return $this;
    }

 
  

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

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
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

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

    /**
     * @return Collection<int, NINinea>
     */
    public function getNinNinea(): Collection
    {
        return $this->ninNinea;
    }

    public function addNinNinea(NINinea $ninNinea): self
    {
        if (!$this->ninNinea->contains($ninNinea)) {
            $this->ninNinea[] = $ninNinea;
            $ninNinea->setNiPersonne($this);
        }

        return $this;
    }

    public function removeNinNinea(NINinea $ninNinea): self
    {
        if ($this->ninNinea->removeElement($ninNinea)) {
            // set the owning side to null (unless already changed)
            if ($ninNinea->getNiPersonne() === $this) {
                $ninNinea->setNiPersonne(null);
            }
        }

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
            $niNineaproposition->setNiPersonne($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getNiPersonne() === $this) {
                $niNineaproposition->setNiPersonne(null);
            }
        }

        return $this;
    }
}
