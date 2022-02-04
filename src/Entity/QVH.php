<?php

namespace App\Entity;

use App\Repository\QVHRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QVHRepository::class)
 * @ORM\Table(name="`CUCI_QVH`")
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

    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
    }

    public function getId(): ?string
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
}
