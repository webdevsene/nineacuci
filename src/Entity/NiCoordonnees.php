<?php

namespace App\Entity;

use App\Repository\NiCoordonneesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiCoordonneesRepository::class)
 *  * @ORM\Table(name="`ni_adresse`")
 */
class NiCoordonnees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="nin_NumVoie")
     */
    private $ninnumVoie;

    /**
     * @ORM\ManyToOne(targetEntity=NiTypevoie::class, inversedBy="niCoordonnees")
     */
    private $ninTypeVoie;

    /**
     * @ORM\Column(type="string",  length=100, nullable=true, name="nin_Voie")
     */
    private $ninVoie;

    /**
     * @ORM\Column(type="text", length=200,  nullable=true, name="nin_Adresse1")
     */
    private $ninadresse1;



    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ninEmail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="nin_AdresseDomicile")
     */
    private $ninadresse2;

    /**
     * @ORM\Column(type="string", length=20, nullable=true, name="nin_Telephon2" )
     */
    private $nintelephon2;



    /**
     * @ORM\Column(type="string", length=10, name="nin_Telephon1")
     */
    private $ninTelephon1;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $create_by;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $update_by;

    /**
     * @ORM\Column(type="date")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=QVH::class, inversedBy="niCoordonnees")
     */
    private $qvh;

    /**
     * @ORM\ManyToOne(targetEntity=NINinea::class, inversedBy="niCoordonnees")
     */
    private $ninNinea;


    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=NiNineaproposition::class, inversedBy="coordonnees")
     */
    private $niNineaproposition;

    /**
     * @ORM\Column(type="string", length=50, nullable=true, name="nin_BP")
     */
    private $ninBP;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ninUrl;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateFin;

    public function __construct()
    {

        $this->created_at=new \DateTime();
        $this->updated_at=new \DateTime();
    }

    public function __toString()
    {
        return $this->ninUrl;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinnumVoie(): ?string
    {
        return $this->ninnumVoie;
    }

    public function setNinnumVoie(string $ninnumVoie): self
    {
        $this->ninnumVoie = $ninnumVoie;

        return $this;
    }

    public function getNinTypevoie(): ?NiTypevoie
    {
        return $this->ninTypeVoie;
    }

    public function setNinTypevoie(?NiTypevoie $ninTypevoie): self
    {
        $this->ninTypeVoie = $ninTypevoie;

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

    public function getNinadresse1(): ?string
    {
        return $this->ninadresse1;
    }

    public function setNinadresse1(?string $ninadresse1): self
    {
        $this->ninadresse1 = $ninadresse1;

        return $this;
    }



    public function getNinEmail(): ?string
    {
        return $this->ninEmail;
    }

    public function setNinEmail(?string $ninEmail): self
    {
        $this->ninEmail = $ninEmail;

        return $this;
    }

    public function getNinadresse2(): ?string
    {
        return $this->ninadresse2;
    }

    public function setNinadresse2(?string $ninadresse2): self
    {
        $this->ninadresse2 = $ninadresse2;

        return $this;
    }

    public function getNintelephon2(): ?string
    {
        return $this->nintelephon2;
    }

    public function setNintelephon2(?string $nintelephon2): self
    {
        $this->nintelephon2 = $nintelephon2;

        return $this;
    }

    public function getNinComEtablissement(): ?string
    {
        return $this->ninComEtablissement;
    }

    public function setNinComEtablissement(?string $ninComEtablissement): self
    {
        $this->ninComEtablissement = $ninComEtablissement;

        return $this;
    }

    public function getNinDept(): ?string
    {
        return $this->ninDept;
    }

    public function setNinDept(?string $ninDept): self
    {
        $this->ninDept = $ninDept;

        return $this;
    }

    public function getNinQrtVillageEtab(): ?string
    {
        return $this->ninQrtVillageEtab;
    }

    public function setNinQrtVillageEtab(?string $ninQrtVillageEtab): self
    {
        $this->ninQrtVillageEtab = $ninQrtVillageEtab;

        return $this;
    }


    public function getNinTelephon1(): ?string
    {
        return $this->ninTelephon1;
    }

    public function setNinTelephon1(string $ninTelephon1): self
    {
        $this->ninTelephon1 = $ninTelephon1;

        return $this;
    }



    public function getCreateBy(): ?string
    {
        return $this->create_by;
    }

    public function setCreateBy(string $create_by): self
    {
        $this->create_by = $create_by;

        return $this;
    }

    public function getUpdateBy(): ?string
    {
        return $this->update_by;
    }

    public function setUpdateBy(string $update_by): self
    {
        $this->update_by = $update_by;

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

    public function getQvh(): ?QVH
    {
        return $this->qvh;
    }

    public function setQvh(?QVH $qvh): self
    {
        $this->qvh = $qvh;

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

    public function getNiNineaproposition(): ?NiNineaproposition
    {
        return $this->niNineaproposition;
    }

    public function setNiNineaproposition(?NiNineaproposition $niNineaproposition): self
    {
        $this->niNineaproposition = $niNineaproposition;

        return $this;
    }

    public function getNinBP(): ?string
    {
        return $this->ninBP;
    }

    public function setNinBP(?string $ninBP): self
    {
        $this->ninBP = $ninBP;

        return $this;
    }

    public function getNinNinea(): ?NINinea
    {
        return $this->ninNinea;
    }

    public function setNinNinea(?NINinea $ninNinea): self
    {
        $this->ninNinea = $ninNinea;

        return $this;
    }

    public function getNinUrl(): ?string
    {
        return $this->ninUrl;
    }

    public function setNinUrl(?string $ninUrl): self
    {
        $this->ninUrl = $ninUrl;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(?\DateTimeInterface $DateFin): self
    {
        $this->DateFin = $DateFin;

        return $this;
    }
}
