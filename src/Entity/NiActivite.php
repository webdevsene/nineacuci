<?php

namespace App\Entity;

use App\Repository\NiActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NiActiviteRepository::class)
 * 
 */
class NiActivite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     *
     */
    private $ninAutact;


    /**
     * @ORM\ManyToOne(targetEntity=SYSCOA::class, inversedBy="niActivites")
     */
    private $refSyscoa;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMA::class, inversedBy="niActivites")
     *
     */
    private $refNaema;

    /**
     * @ORM\ManyToOne(targetEntity=NAEMAS::class, inversedBy="niActivites")
     */
    private $refNaemas;

    /**
     * @ORM\ManyToOne(targetEntity=Citi::class, inversedBy="niActivites")
     */
    private $refCiti;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $created_by;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $updated_by;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\Column(type="date")
     */
    private $updated_at;


    /**
     * @ORM\ManyToOne(targetEntity=NiNineaproposition::class, inversedBy="ninActivites")
     */
    private $niNineaproposition;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     */
    private $statActivprincipale;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="ninActivite")
     *  
     */
    private $nINinea;


    /**
     * @ORM\Column(type="date", nullable=true)
     *
     */
    private $DateDeCloture;
  

    public function __construct()
    {
        $this->ninea_demande = new ArrayCollection();
        $this->id = uniqid();
        $this->created_at=new \DateTime();
        $this->updated_at=new \DateTime();

    }

    public function __toString()
    {
        return $this->id;
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNinAutact(): ?string
    {
        return $this->ninAutact;
    }

    public function setNinAutact(?string $ninAutact): self
    {
        $this->ninAutact = $ninAutact;

        return $this;
    }


    public function getRefSyscoa(): ?Syscoa
    {
        return $this->refSyscoa;
    }

    public function setRefSyscoa(?Syscoa $refSyscoa): self
    {
        $this->refSyscoa = $refSyscoa;

        return $this;
    }

    public function getRefNaema(): ?NAEMA
    {
        return $this->refNaema;
    }

    public function setRefNaema(?NAEMA $refNaema): self
    {
        $this->refNaema = $refNaema;

        return $this;
    }

   

    public function getRefCiti(): ?Citi
    {
        return $this->refCiti;
    }

    public function setRefCiti(?Citi $refCiti): self
    {
        $this->refCiti = $refCiti;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->created_by;
    }

    public function setCreatedBy(?string $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(string $updated_by): self
    {
        $this->updated_by = $updated_by;

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



    public function getNiNineaproposition(): ?NiNineaproposition
    {
        return $this->niNineaproposition;
    }

    public function setNiNineaproposition(?NiNineaproposition $niNineaproposition): self
    {
        $this->niNineaproposition = $niNineaproposition;

        return $this;
    }

    public function getStatActivPrincipale(): ?bool
    {
        return $this->statActivprincipale;
    }

    public function setStatActivPrincipale(?bool $statActiv_principale): self
    {
        $this->statActivprincipale = $statActiv_principale;

        return $this;
    }

    public function getNINinea(): ?NINinea
    {
        return $this->nINinea;
    }

    public function setNINinea(?NINinea $nINinea): self
    {
        $this->nINinea = $nINinea;

        return $this;
    }

    public function getRefNaemas(): ?NAEMAS
    {
        return $this->refNaemas;
    }

    public function setRefNaemas(?NAEMAS $refNaemas): self
    {
        $this->refNaemas = $refNaemas;

        return $this;
    }

    public function isStatActivprincipale(): ?bool
    {
        return $this->statActivprincipale;
    }

    public function getDateDeCloture(): ?\DateTimeInterface
    {
        return $this->DateDeCloture;
    }

    public function setDateDeCloture(?\DateTimeInterface $DateDeCloture): self
    {
        $this->DateDeCloture = $DateDeCloture;

        return $this;
    }

    

    
}
