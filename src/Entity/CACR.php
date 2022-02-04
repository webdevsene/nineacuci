<?php

namespace App\Entity;

use App\Repository\CACRRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CACRRepository::class)
 */
class CACR
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codeCacr;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    private $libelle;

    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    

    /**
     * @ORM\ManyToOne(targetEntity=CAV::class, inversedBy="cACRs")
     */
    private $cacrCAVID;

   

    /**
     * @ORM\OneToMany(targetEntity=QVH::class, mappedBy="qvhCACRID")
     */
    private $qVHs;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $cacrActiveF;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cacrCDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cacrCUSER;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cacrCDMIG;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cacrMDATE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cacrMUSER;

    public function __construct()
    {
        $this->qVHs = new ArrayCollection();
    }


     /**
     * toString
     * @return string 
     */
    public  function __toString()
    {
        return $this->libelle;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCodeCacr(): ?string
    {
        return $this->codeCacr;
    }

    public function setCodeCacr(?string $codeCacr): self
    {
        $this->codeCacr = $codeCacr;

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
   

   

    public function getCacrCAVID(): ?CAV
    {
        return $this->cacrCAVID;
    }

    public function setCacrCAVID(?CAV $cacrCAVID): self
    {
        $this->cacrCAVID = $cacrCAVID;

        return $this;
    }

  

    /**
     * @return Collection|QVH[]
     */
    public function getQVHs(): Collection
    {
        return $this->qVHs;
    }

    public function addQVH(QVH $qVH): self
    {
        if (!$this->qVHs->contains($qVH)) {
            $this->qVHs[] = $qVH;
            $qVH->setQvhCACRID($this);
        }

        return $this;
    }

    public function removeQVH(QVH $qVH): self
    {
        if ($this->qVHs->removeElement($qVH)) {
            // set the owning side to null (unless already changed)
            if ($qVH->getQvhCACRID() === $this) {
                $qVH->setQvhCACRID(null);
            }
        }

        return $this;
    }

    public function getCacrActiveF(): ?string
    {
        return $this->cacrActiveF;
    }

    public function setCacrActiveF(?string $cacrActiveF): self
    {
        $this->cacrActiveF = $cacrActiveF;

        return $this;
    }

    public function getCacrCDATE(): ?string
    {
        return $this->cacrCDATE;
    }

    public function setCacrCDATE(?string $cacrCDATE): self
    {
        $this->cacrCDATE = $cacrCDATE;

        return $this;
    }

    public function getCacrCUSER(): ?string
    {
        return $this->cacrCUSER;
    }

    public function setCacrCUSER(?string $cacrCUSER): self
    {
        $this->cacrCUSER = $cacrCUSER;

        return $this;
    }

    public function getCacrCDMIG(): ?string
    {
        return $this->cacrCDMIG;
    }

    public function setCacrCDMIG(?string $cacrCDMIG): self
    {
        $this->cacrCDMIG = $cacrCDMIG;

        return $this;
    }

    public function getCacrMDATE(): ?string
    {
        return $this->cacrMDATE;
    }

    public function setCacrMDATE(?string $cacrMDATE): self
    {
        $this->cacrMDATE = $cacrMDATE;

        return $this;
    }

    public function getCacrMUSER(): ?string
    {
        return $this->cacrMUSER;
    }

    public function setCacrMUSER(?string $cacrMUSER): self
    {
        $this->cacrMUSER = $cacrMUSER;

        return $this;
    }
}
