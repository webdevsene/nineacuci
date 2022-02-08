<?php

namespace App\Entity;

use App\Repository\CompteDeResultatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompteDeResultatsRepository::class)
 * @ORM\Table(name="cuci_compte_de_resultats")
 */
class CompteDeResultats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rank;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $submit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref_code;

    /**
     * @ORM\Column(type="string", length=6, nullable=true)
     */
    private $annee_financiere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploaded_file_name;

    
    /**
     * @ORM\ManyToOne(targetEntity=Repertoire::class, inversedBy="compte_de_resultats")
     */
    private $cuci_rep_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $net2;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSubmit(): ?bool
    {
        return $this->submit;
    }

    public function setSubmit(?bool $submit): self
    {
        $this->submit = $submit;

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

    public function getRefCode(): ?string
    {
        return $this->ref_code;
    }

    public function setRefCode(?string $ref_code): self
    {
        $this->ref_code = $ref_code;

        return $this;
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

    public function getUploadedFileName(): ?string
    {
        return $this->uploaded_file_name;
    }

    public function setUploadedFileName(?string $uploaded_file_name): self
    {
        $this->uploaded_file_name = $uploaded_file_name;

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

    public function __toString()
    {
        return $this->rank;
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
}
