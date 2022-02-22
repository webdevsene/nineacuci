<?php

namespace App\Entity;

use App\Repository\RefAggRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Uid\Uuid;
/**
 * @ORM\Entity(repositoryClass=RefAggRepository::class)
 * @ORM\Table(name="`cuci_all_agg`")
 */
class RefAgg
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $parent;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="refAgg")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBilan::class, inversedBy="refAgg")
     */
    private $typeBilan;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $surlignee;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $signes;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $notes;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

  

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(?string $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTypeBilan(): ?TypeBilan
    {
        return $this->typeBilan;
    }

    public function setTypeBilan(?TypeBilan $typeBilan): self
    {
        $this->typeBilan = $typeBilan;

        return $this;
    }

    public function getSurlignee(): ?bool
    {
        return $this->surlignee;
    }

    public function setSurlignee(?bool $surlignee): self
    {
        $this->surlignee = $surlignee;

        return $this;
    }

    public function getSignes(): ?string
    {
        return $this->signes;
    }

    public function setSignes(?string $signes): self
    {
        $this->signes = $signes;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }
}
