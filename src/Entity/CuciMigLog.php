<?php

namespace App\Entity;

use App\Repository\CuciMigLogRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=CuciMigLogRepository::class)
 */
class CuciMigLog
{
     /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cuciMigLogs")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cuciMiglogsModifier")
     */
    private $modifiedBy;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $logFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logFileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $uploadedFile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $count;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $success;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;
    



    public function __construct()
    {
        $this->id =uniqid();
        $this->createdDate=new \DateTime();
        $this->modifiedDate=new \DateTime();
    }

    public function __toString()
    {
        return $this->logFileName;
    }


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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

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

    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modifiedDate;
    }

    public function setModifiedDate(?\DateTimeInterface $modifiedDate): self
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    public function getLogFile(): ?string
    {
        return $this->logFile;
    }

    public function setLogFile(?string $logFile): self
    {
        $this->logFile = $logFile;

        return $this;
    }

    public function getLogFileName(): ?string
    {
        return $this->logFileName;
    }

    public function setLogFileName(?string $logFileName): self
    {
        $this->logFileName = $logFileName;

        return $this;
    }

    public function getUploadedFile(): ?string
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(?string $uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getSuccess(): ?int
    {
        return $this->success;
    }

    public function setSuccess(?int $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
