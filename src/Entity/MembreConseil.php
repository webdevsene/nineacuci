<?php

namespace App\Entity;

use App\Repository\MembreConseilRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=MembreConseilRepository::class)
 * @ORM\Table(name="ref_membreconseil")
 */
class MembreConseil
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="membreConseils")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="membreConseilsModifiedBy")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $addresse;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nom;

     /**
     * @ORM\ManyToOne(targetEntity=Qualite::class, inversedBy="membreConseils")
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $prenom;


    public function __construct()
    {
        $this->id = uniqid();
         $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
    }

    
    public function __toString()
    {

            return $this->nom;
        
    }



    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="membreConseils")
     */
    private $repertoire;

    public function getId(): ?string
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeInterface $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): self
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    public function getAddresse(): ?string
    {
        return $this->addresse;
    }

    public function setAddresse(?string $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPosition(): ?Qualite
    {
        return $this->position;
    }

    public function setPosition(?Qualite $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRepertoire(): ?Repertoire
    {
        return $this->repertoire;
    }

    public function setRepertoire(?Repertoire $repertoire): self
    {
        $this->repertoire = $repertoire;

        return $this;
    }
}
