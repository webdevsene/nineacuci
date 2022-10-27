<?php

namespace App\Entity;

use App\Repository\DbChangeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=DbChangeRepository::class)
 * @ORM\Table(name="`cuci_ninea_db_journal_history`")
 */
class DbChange
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    public function __construct()
    {
        $this->created_at=new \DateTime();
        $this->id =uniqid();
        
    }


    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, name="tableau")
     */
    private $table_name;

    /**
     * @ORM\Column(type="string", length=255, name="entityID")
     */
    private $entity_id;

    /**
     * @ORM\Column(type="string", length=255, name="action")
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255, name="field_name")
     */
    private $field_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $old_value;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $new_value;

    /**
     * @ORM\Column(type="string", length=255, name="userID")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $codeCuci;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="dateSaisie")
     */
    private $dateSaisie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="saisiePar")
     */
    private $owner;



    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id;
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

    public function getTableName(): ?string
    {
        return $this->table_name;
    }

    public function setTableName(string $table_name): self
    {
        $this->table_name = $table_name;

        return $this;
    }

    public function getEntityId(): ?string
    {
        return $this->entity_id;
    }

    public function setEntityId(string $entity_id): self
    {
        $this->entity_id = $entity_id;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getFieldName(): ?string
    {
        return $this->field_name;
    }

    public function setFieldName(string $field_name): self
    {
        $this->field_name = $field_name;

        return $this;
    }

    public function getOldValue(): ?string
    {
        return $this->old_value;
    }

    public function setOldValue(?string $old_value): self
    {
        $this->old_value = $old_value;

        return $this;
    }

    public function getNewValue(): ?string
    {
        return $this->new_value;
    }

    public function setNewValue(?string $new_value): self
    {
        $this->new_value = $new_value;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCodeCuci(): ?string
    {
        return $this->codeCuci;
    }

    public function setCodeCuci(?string $codeCuci): self
    {
        $this->codeCuci = $codeCuci;

        return $this;
    }

    public function getDateSaisie(): ?\DateTimeInterface
    {
        return $this->dateSaisie;
    }

    public function setDateSaisie(?\DateTimeInterface $dateSaisie): self
    {
        $this->dateSaisie = $dateSaisie;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(?string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
