<?php

namespace App\Entity;

use App\Repository\NiAdministrationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiAdministrationRepository::class)
 */
class NiAdministration
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=10)
     */
    private $id;

    /**
     * @ORM\Column(type="string",  length=100,nullable=true)
     */
    private $admcode;

    /**
     * @ORM\Column(type="string",  length=200, nullable=true)
     */
    private $admlibelle;

    /**
     * @ORM\OneToMany(targetEntity=NiNineaproposition::class, mappedBy="ninAdministration")
     */
    private $niNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=NINinea::class, mappedBy="ninAdministration")
     */
    private $nINineas;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="niAdministration")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $admContactDetails;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNiNineaproposition::class, mappedBy="ninAdministration")
     */
    private $historyNiNineapropositions;

    /**
     * @ORM\OneToMany(targetEntity=HistoryNINinea::class, mappedBy="ninAdministration")
     */
    private $historyNINineas;

    /**
     * @ORM\OneToMany(targetEntity=TempNINinea::class, mappedBy="ninAdministration")
     */
    private $tempNINineas;

    public function __construct()
    {
        $this->niNineapropositions = new ArrayCollection();
        $this->nINineas = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->historyNiNineapropositions = new ArrayCollection();
        $this->historyNINineas = new ArrayCollection();
        $this->tempNINineas = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdmcode(): ?string
    {
        return $this->admcode;
    }

    public function setAdmcode(?string $admcode): self
    {
        $this->admcode = $admcode;

        return $this;
    }

    public function getAdmlibelle(): ?string
    {
        return $this->admlibelle;
    }

    public function setAdmlibelle(?string $admlibelle): self
    {
        $this->admlibelle = $admlibelle;

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
            $niNineaproposition->setNinAdministration($this);
        }

        return $this;
    }

    public function removeNiNineaproposition(NiNineaproposition $niNineaproposition): self
    {
        if ($this->niNineapropositions->removeElement($niNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($niNineaproposition->getNinAdministration() === $this) {
                $niNineaproposition->setNinAdministration(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->admlibelle;
    }

    /**
     * @return Collection<int, NINinea>
     */
    public function getNINineas(): Collection
    {
        return $this->nINineas;
    }

    public function addNINinea(NINinea $nINinea): self
    {
        if (!$this->nINineas->contains($nINinea)) {
            $this->nINineas[] = $nINinea;
            $nINinea->setNinAdministration($this);
        }

        return $this;
    }

    public function removeNINinea(NINinea $nINinea): self
    {
        if ($this->nINineas->removeElement($nINinea)) {
            // set the owning side to null (unless already changed)
            if ($nINinea->getNinAdministration() === $this) {
                $nINinea->setNinAdministration(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setNiAdministration($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getNiAdministration() === $this) {
                $user->setNiAdministration(null);
            }
        }

        return $this;
    }

    public function getAdmContactDetails(): ?string
    {
        return $this->admContactDetails;
    }

    public function setAdmContactDetails(?string $admContactDetails): self
    {
        $this->admContactDetails = $admContactDetails;

        return $this;
    }

    /**
     * @return Collection<int, HistoryNiNineaproposition>
     */
    public function getHistoryNiNineapropositions(): Collection
    {
        return $this->historyNiNineapropositions;
    }

    public function addHistoryNiNineaproposition(HistoryNiNineaproposition $historyNiNineaproposition): self
    {
        if (!$this->historyNiNineapropositions->contains($historyNiNineaproposition)) {
            $this->historyNiNineapropositions[] = $historyNiNineaproposition;
            $historyNiNineaproposition->setNinAdministration($this);
        }

        return $this;
    }

    public function removeHistoryNiNineaproposition(HistoryNiNineaproposition $historyNiNineaproposition): self
    {
        if ($this->historyNiNineapropositions->removeElement($historyNiNineaproposition)) {
            // set the owning side to null (unless already changed)
            if ($historyNiNineaproposition->getNinAdministration() === $this) {
                $historyNiNineaproposition->setNinAdministration(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HistoryNINinea>
     */
    public function getHistoryNINineas(): Collection
    {
        return $this->historyNINineas;
    }

    public function addHistoryNINinea(HistoryNINinea $historyNINinea): self
    {
        if (!$this->historyNINineas->contains($historyNINinea)) {
            $this->historyNINineas[] = $historyNINinea;
            $historyNINinea->setNinAdministration($this);
        }

        return $this;
    }

    public function removeHistoryNINinea(HistoryNINinea $historyNINinea): self
    {
        if ($this->historyNINineas->removeElement($historyNINinea)) {
            // set the owning side to null (unless already changed)
            if ($historyNINinea->getNinAdministration() === $this) {
                $historyNINinea->setNinAdministration(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TempNINinea>
     */
    public function getTempNINineas(): Collection
    {
        return $this->tempNINineas;
    }

    public function addTempNINinea(TempNINinea $tempNINinea): self
    {
        if (!$this->tempNINineas->contains($tempNINinea)) {
            $this->tempNINineas[] = $tempNINinea;
            $tempNINinea->setNinAdministration($this);
        }

        return $this;
    }

    public function removeTempNINinea(TempNINinea $tempNINinea): self
    {
        if ($this->tempNINineas->removeElement($tempNINinea)) {
            // set the owning side to null (unless already changed)
            if ($tempNINinea->getNinAdministration() === $this) {
                $tempNINinea->setNinAdministration(null);
            }
        }

        return $this;
    }
}
