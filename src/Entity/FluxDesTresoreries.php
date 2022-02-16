<?php

namespace App\Entity;

use App\Repository\FluxDesTresoreriesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=FluxDesTresoreriesRepository::class)
 * @ORM\Table(name="`CUCI_ETATS_DES_TRESORERIES`")
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
    private $net1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net2;

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
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
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

    public function __construct()
    {
        $this->id = Uuid::v4();
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
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
}
