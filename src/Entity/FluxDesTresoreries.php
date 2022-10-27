<?php

namespace App\Entity;

use App\Repository\FluxDesTresoreriesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=FluxDesTresoreriesRepository::class)
 * @ORM\Table(name="`cuci_etats_des_tresoreries`")
 */
class FluxDesTresoreries
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $annee_financiere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net1=0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net2=0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $upload_file_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="fluxDesTresoreries")
     */
    private $cuci_rep_code;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="fluxDesTresoreries")
     */
    private $modifiedBy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="fluxDesTresoreriesUpBy")
     */
    private $editedBy;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $demat;

    public function __construct()
    {
        $this->createdAt=new \DateTime();
        $this->updatedAt=new \DateTime();
        $this->id =uniqid();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAnneeFinanciere(): ?string
    {
        return $this->annee_financiere;
    }

    public function setAnneeFinanciere(?string $annee_financiere): self
    {
        $this->annee_financiere = $annee_financiere;

        return $this;
    }

    public function getRefCode(): ?string
    {
        return $this->ref_code;
    }

    public function setRefCode(?string $ref_code): self
    {
        $this->ref_code = $ref_code;

        return $this;
    }

    public function getNet1(): ?string
    {
        return $this->net1;
    }

    public function setNet1(?string $net1): self
    {
        $this->net1 = $net1;

        return $this;
    }

    public function getNet2(): ?string
    {
        return $this->net2;
    }

    public function setNet2(?string $net2): self
    {
        $this->net2 = $net2;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUploadFileName(): ?string
    {
        return $this->upload_file_name;
    }

    public function setUploadFileName(?string $upload_file_name): self
    {
        $this->upload_file_name = $upload_file_name;

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

    public function getCreatedBy(): ?\DateTimeInterface
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?\DateTimeInterface $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUpdatedBy(): ?\DateTimeInterface
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?\DateTimeInterface $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getCuciRepCode(): ?Repertoire
    {
        return $this->cuci_rep_code;
    }

    public function setCuciRepCode(?Repertoire $cuci_rep_code): self
    {
        $this->cuci_rep_code = $cuci_rep_code;

        return $this;
    }

    public function getSubmit(): ?bool
    {
        return $this->submit;
    }

    public function setSubmit(?bool $submit): self
    {
        $this->submit = $submit;

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

    public function getEditedBy(): ?User
    {
        return $this->editedBy;
    }

    public function setEditedBy(?User $editedBy): self
    {
        $this->editedBy = $editedBy;

        return $this;
    }

    public function isSubmit(): ?bool
    {
        return $this->submit;
    }

    public function __toString( ): string
    {
        return $this->id;
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
