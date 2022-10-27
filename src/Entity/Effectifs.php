<?php

namespace App\Entity;

use App\Repository\EffectifsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=EffectifsRepository::class)
 * @ORM\Table(name="`cuci_effectifs_masse_salariale`")
 */
class Effectifs
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="effectifs")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="effectifsUpBy")
     */
    private $updatedBy;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploadedFileName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $units;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(name="TOTAL_EF", type="string", length=100, nullable=true)
     */
    private $totalEf;

    /**
     * @ORM\Column(name="TOTAL_MS", type="string", length=100, nullable=true)
     */
    private $totalMs;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qualification;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="effectifs")
     */
    private $repertoire;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $anneeFinanciere;

    /**
     * @ORM\Column(name="FACF", type="string", length=255, nullable=true)
     */
    private $facm;

    /**
     * @ORM\Column(name="FACM", type="string", length=255, nullable=true)
     */
    private $facf;

    /**
     * @ORM\Column(name="HMFEF", type="string", length=255, nullable=true)
     */
    private $hmfef;

    /**
     * @ORM\Column(name="HMMEF", type="string", length=255, nullable=true)
     */
    private $hmmef;

    /**
     * @ORM\Column(name="MHMFEF", type="string", length=255, nullable=true)
     */
    private $mhmfef;

    /**
     * @ORM\Column(name="MHMMEF", type="string", length=255, nullable=true)
     */
    private $mhmmef;

    /**
     * @ORM\Column(name="MNFEF", type="string", length=255, nullable=true)
     */
    private $mnfef;

    /**
     * @ORM\Column(name="MNMEF", type="string", length=255, nullable=true)
     */
    private $mnmef;

    /**
     * @ORM\Column(name="MUMFEF", type="string", length=255, nullable=true)
     */
    private $mumfef;

    /**
     * @ORM\Column(name="MUMMEF", type="string", length=255, nullable=true)
     */
    private $mummef;

    /**
     * @ORM\Column(name="NFEF", type="string", length=255, nullable=true)
     */
    private $nfef;

    /**
     * @ORM\Column(name="NMEF", type="string", length=255, nullable=true)
     */
    private $nmef;

    /**
     * @ORM\Column(name="UMFEF", type="string", length=255, nullable=true)
     */
    private $umfef;

    /**
     * @ORM\Column(name="UMMEF", type="string", length=255, nullable=true)
     */
    private $ummef;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $refCode;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $demat;
    
    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->id = uniqid();
    }

    public function __toString()
    {
        return $this->id;
    }




    public function getId(): ?string
    {
        return $this->id;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getUploadedFileName(): ?string
    {
        return $this->uploadedFileName;
    }

    public function setUploadedFileName(?string $uploadedFileName): self
    {
        $this->uploadedFileName = $uploadedFileName;

        return $this;
    }

    public function getUnits(): ?string
    {
        return $this->units;
    }

    public function setUnits(?string $units): self
    {
        $this->units = $units;

        return $this;
    }

    public function getSubmit(): ?string
    {
        return $this->submit;
    }

    public function setSubmit(?string $submit): self
    {
        $this->submit = $submit;

        return $this;
    }

    public function getTotalEf(): ?string
    {
        return $this->totalEf;
    }

    public function setTotalEf(?string $totalEf): self
    {
        $this->totalEf = $totalEf;

        return $this;
    }

    public function getTotalMs(): ?string
    {
        return $this->totalMs;
    }

    public function setTotalMs(?string $totalMs): self
    {
        $this->totalMs = $totalMs;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(?string $qualification): self
    {
        $this->qualification = $qualification;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getAnneeFinanciere(): ?string
    {
        return $this->anneeFinanciere;
    }

    public function setAnneeFinanciere(?string $anneeFinanciere): self
    {
        $this->anneeFinanciere = $anneeFinanciere;

        return $this;
    }

    public function getFacm(): ?string
    {
        return $this->facm;
    }

    public function setFacm(?string $facm): self
    {
        $this->facm = $facm;

        return $this;
    }

    public function getFacf(): ?string
    {
        return $this->facf;
    }

    public function setFacf(?string $facf): self
    {
        $this->facf = $facf;

        return $this;
    }

    public function getHmfef(): ?string
    {
        return $this->hmfef;
    }

    public function setHmfef(?string $hmfef): self
    {
        $this->hmfef = $hmfef;

        return $this;
    }

    public function getHmmef(): ?string
    {
        return $this->hmmef;
    }

    public function setHmmef(?string $hmmef): self
    {
        $this->hmmef = $hmmef;

        return $this;
    }

    public function getMhmfef(): ?string
    {
        return $this->mhmfef;
    }

    public function setMhmfef(?string $mhmfef): self
    {
        $this->mhmfef = $mhmfef;

        return $this;
    }

    public function getMhmmef(): ?string
    {
        return $this->mhmmef;
    }

    public function setMhmmef(?string $mhmmef): self
    {
        $this->mhmmef = $mhmmef;

        return $this;
    }

    public function getMnfef(): ?string
    {
        return $this->mnfef;
    }

    public function setMnfef(?string $mnfef): self
    {
        $this->mnfef = $mnfef;

        return $this;
    }

    public function getMnmef(): ?string
    {
        return $this->mnmef;
    }

    public function setMnmef(?string $mnmef): self
    {
        $this->mnmef = $mnmef;

        return $this;
    }

    public function getMumfef(): ?string
    {
        return $this->mumfef;
    }

    public function setMumfef(?string $mumfef): self
    {
        $this->mumfef = $mumfef;

        return $this;
    }

    public function getMummef(): ?string
    {
        return $this->mummef;
    }

    public function setMummef(?string $mummef): self
    {
        $this->mummef = $mummef;

        return $this;
    }

    public function getNfef(): ?string
    {
        return $this->nfef;
    }

    public function setNfef(?string $nfef): self
    {
        $this->nfef = $nfef;

        return $this;
    }

    /**
     * nationaux masculin effectif
     *
     * @return string|null
     */
    public function getNmef(): ?string
    {
        return $this->nmef;
    }

    public function setNmef(?string $nmef): self
    {
        $this->nmef = $nmef;

        return $this;
    }

    public function getUmfef(): ?string
    {
        return $this->umfef;
    }

    public function setUmfef(?string $umfef): self
    {
        $this->umfef = $umfef;

        return $this;
    }

    public function getUmmef(): ?string
    {
        return $this->ummef;
    }

    public function setUmmef(?string $ummef): self
    {
        $this->ummef = $ummef;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of refCode
     */ 
    public function getRefCode(): ?string
    {
        return $this->refCode;
    }

    /**
     * Set the value of refCode
     *
     * @return  self
     */ 
    public function setRefCode(?string $refCode): self
    {
        $this->refCode = $refCode;

        return $this;
    }

    public function isDemat(): ?bool
    {
        return $this->demat;
    }

    public function setDemat(?bool $demat): self
    {
        $this->demat = $demat;

        return $this;
    }
}
