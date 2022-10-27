<?php

namespace App\Entity;

use App\Repository\QVHRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QVHRepository::class)
 * @ORM\Table(name="`ref_qvh`")
 */
class QVH
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $codeQvh;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $libelle;


       /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    

    /**
     * @ORM\ManyToOne(targetEntity=CACR::class, inversedBy="qVHs")
     */
    private $qvhCACRID;



    /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="qvh")
     */
    private $repertoires;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qvhCUSER;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qvhActiveF;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qvhCDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qvhCDMIG;

    /**
     * @ORM\Column(type="string", length=27, nullable=true)
     */
    private $qvhMDATE;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $qvhUSER;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $qvhType;

    /**
     * @ORM\OneToMany(targetEntity=NiCoordonnees::class, mappedBy="qvh")
     */
    private $niCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=NiPersonne::class, mappedBy="ninQvh")
     */
    private $niPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=NiDirigeant::class, mappedBy="ninQvh")
     */
    private $niDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiCoordonnees::class, mappedBy="qvh")
     */
    private $historyNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiDirigeant::class, mappedBy="ninQvh")
     */
    private $historyNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiPersonne::class, mappedBy="ninQvh")
     */
    private $historyNiPersonnes;

    /**
     * @ORM\OneToMany(targetEntity=TempNiCoordonnees::class, mappedBy="qvh")
     */
    private $tempNiCoordonnees;

    /**
     * @ORM\OneToMany(targetEntity=TempNiDirigeant::class, mappedBy="ninQvh")
     */
    private $tempNiDirigeants;

    /**
     * @ORM\OneToMany(targetEntity=TempNiPersonne::class, mappedBy="ninQvh")
     */
    private $tempNiPersonnes;

    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
        $this->niCoordonnees = new ArrayCollection();
        $this->niPersonnes = new ArrayCollection();
        $this->niDirigeants = new ArrayCollection();
        $this->historyNiCoordonnees = new ArrayCollection();
        $this->historyNiDirigeants = new ArrayCollection();
        $this->historyNiPersonnes = new ArrayCollection();
        $this->tempNiCoordonnees = new ArrayCollection();
        $this->tempNiDirigeants = new ArrayCollection();
        $this->tempNiPersonnes = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString()
    {

            return $this->id;
        
    }

    public function setId($id)
    {
         $this->id=$id;
    }

    public function getCodeQvh(): ?string
    {
        return $this->codeQvh;
    }

    public function setCodeQvh(?string $codeQvh): self
    {
        $this->codeQvh = $codeQvh;

        return $this;
    }


    
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
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

 


    public function getQvhCACRID(): ?CACR
    {
        return $this->qvhCACRID;
    }

    public function setQvhCACRID(?CACR $qvhCACRID): self
    {
        $this->qvhCACRID = $qvhCACRID;

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
            $repertoire->setQvh($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoires->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getQvh() === $this) {
                $repertoire->setQvh(null);
            }
        }

        return $this;
    }

    public function getQvhCUSER(): ?string
    {
        return $this->qvhCUSER;
    }

    public function setQvhCUSER(?string $qvhCUSER): self
    {
        $this->qvhCUSER = $qvhCUSER;

        return $this;
    }

    public function getQvhActiveF(): ?string
    {
        return $this->qvhActiveF;
    }

    public function setQvhActiveF(?string $qvhActiveF): self
    {
        $this->qvhActiveF = $qvhActiveF;

        return $this;
    }

    public function getQvhCDATE(): ?string
    {
        return $this->qvhCDATE;
    }

    public function setQvhCDATE(?string $qvhCDATE): self
    {
        $this->qvhCDATE = $qvhCDATE;

        return $this;
    }

    public function getQvhCDMIG(): ?string
    {
        return $this->qvhCDMIG;
    }

    public function setQvhCDMIG(?string $qvhCDMIG): self
    {
        $this->qvhCDMIG = $qvhCDMIG;

        return $this;
    }

    public function getQvhMDATE(): ?string
    {
        return $this->qvhMDATE;
    }

    public function setQvhMDATE(?string $qvhMDATE): self
    {
        $this->qvhMDATE = $qvhMDATE;

        return $this;
    }

    public function getQvhUSER(): ?string
    {
        return $this->qvhUSER;
    }

    public function setQvhUSER(?string $qvhUSER): self
    {
        $this->qvhUSER = $qvhUSER;

        return $this;
    }

    public function getQvhType(): ?string
    {
        return $this->qvhType;
    }

    public function setQvhType(string $qvhType): self
    {
        $this->qvhType = $qvhType;

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
            $niCoordonnee->setQvh($this);
        }

        return $this;
    }

    public function removeNiCoordonnee(NiCoordonnees $niCoordonnee): self
    {
        if ($this->niCoordonnees->removeElement($niCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($niCoordonnee->getQvh() === $this) {
                $niCoordonnee->setQvh(null);
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
            $niPersonne->setNinQvh($this);
        }

        return $this;
    }

    public function removeNiPersonne(NiPersonne $niPersonne): self
    {
        if ($this->niPersonnes->removeElement($niPersonne)) {
            // set the owning side to null (unless already changed)
            if ($niPersonne->getNinQvh() === $this) {
                $niPersonne->setNinQvh(null);
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
            $niDirigeant->setNinQvh($this);
        }

        return $this;
    }

    public function removeNiDirigeant(NiDirigeant $niDirigeant): self
    {
        if ($this->niDirigeants->removeElement($niDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($niDirigeant->getNinQvh() === $this) {
                $niDirigeant->setNinQvh(null);
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
            $historyNiCoordonnee->setQvh($this);
        }

        return $this;
    }

    public function removeHistoryNiCoordonnee(HistoryNiCoordonnees $historyNiCoordonnee): self
    {
        if ($this->historyNiCoordonnees->removeElement($historyNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($historyNiCoordonnee->getQvh() === $this) {
                $historyNiCoordonnee->setQvh(null);
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
            $historyNiDirigeant->setNinQvh($this);
        }

        return $this;
    }

    public function removeHistoryNiDirigeant(HistoryNiDirigeant $historyNiDirigeant): self
    {
        if ($this->historyNiDirigeants->removeElement($historyNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($historyNiDirigeant->getNinQvh() === $this) {
                $historyNiDirigeant->setNinQvh(null);
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
            $historyNiPersonne->setNinQvh($this);
        }

        return $this;
    }

    public function removeHistoryNiPersonne(HistoryNiPersonne $historyNiPersonne): self
    {
        if ($this->historyNiPersonnes->removeElement($historyNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($historyNiPersonne->getNinQvh() === $this) {
                $historyNiPersonne->setNinQvh(null);
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
            $tempNiCoordonnee->setQvh($this);
        }

        return $this;
    }

    public function removeTempNiCoordonnee(TempNiCoordonnees $tempNiCoordonnee): self
    {
        if ($this->tempNiCoordonnees->removeElement($tempNiCoordonnee)) {
            // set the owning side to null (unless already changed)
            if ($tempNiCoordonnee->getQvh() === $this) {
                $tempNiCoordonnee->setQvh(null);
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
            $tempNiDirigeant->setNinQvh($this);
        }

        return $this;
    }

    public function removeTempNiDirigeant(TempNiDirigeant $tempNiDirigeant): self
    {
        if ($this->tempNiDirigeants->removeElement($tempNiDirigeant)) {
            // set the owning side to null (unless already changed)
            if ($tempNiDirigeant->getNinQvh() === $this) {
                $tempNiDirigeant->setNinQvh(null);
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
            $tempNiPersonne->setNinQvh($this);
        }

        return $this;
    }

    public function removeTempNiPersonne(TempNiPersonne $tempNiPersonne): self
    {
        if ($this->tempNiPersonnes->removeElement($tempNiPersonne)) {
            // set the owning side to null (unless already changed)
            if ($tempNiPersonne->getNinQvh() === $this) {
                $tempNiPersonne->setNinQvh(null);
            }
        }

        return $this;
    }
}
