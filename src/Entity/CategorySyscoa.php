<?php

namespace App\Entity;

use App\Repository\CategorySyscoaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CategorySyscoaRepository::class)
 * @ORM\Table(name="ref_category_syscoa")
 */
class CategorySyscoa
{
   /**
     * @ORM\Id
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $id;

   

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=SYSCOA::class, mappedBy="categorySyscoa")
     */
    private $syscoa;

    public function __construct()
    {
        $this->syscoa = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
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

    /**
     * @return Collection|SYSCOA[]
     */
    public function getSyscoa(): Collection
    {
        return $this->syscoa;
    }

    public function addSyscoa(SYSCOA $syscoa): self
    {
        if (!$this->syscoa->contains($syscoa)) {
            $this->syscoa[] = $syscoa;
            $syscoa->setCategorySyscoa($this);
        }

        return $this;
    }

    public function removeSyscoa(SYSCOA $syscoa): self
    {
        if ($this->syscoa->removeElement($syscoa)) {
            // set the owning side to null (unless already changed)
            if ($syscoa->getCategorySyscoa() === $this) {
                $syscoa->setCategorySyscoa(null);
            }
        }

        return $this;
    }
}
