<?php

namespace App\Entity;

use App\Repository\ControlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=ControlRepository::class)
 */
class Control
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;



     /**
     * @ORM\OneToMany(targetEntity=Repertoire::class, mappedBy="controle")
     */
    private $repertoires;



    public function __construct()
    {
        $this->repertoires = new ArrayCollection();
         $this->id = Uuid::v4();
    }
    


    public function getCodeLibelle(): ?string
    {
        return $this->id."-".$this->libelle;
    }



    /**
     * @return Collection|Repertoires[]
     */
    public function getRepertoire()
    {
        return $this->repertoires;
    }

    public function addRepertoire(Repertoire $repertoire): self
    {
        if (!$this->repertoires->contains($repertoire)) {
            $this->repertoires[] = $repertoire;
            $repertoire->setControle($this);
        }

        return $this;
    }

    public function removeRepertoire(Repertoire $repertoire): self
    {
        if ($this->repertoire->removeElement($repertoire)) {
            // set the owning side to null (unless already changed)
            if ($repertoire->getControle() === $this) {
                $repertoire->setControle(null);
            }
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
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
}
