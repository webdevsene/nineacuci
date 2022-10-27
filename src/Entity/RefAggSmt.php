<?php

namespace App\Entity;

use App\Repository\RefAggSmtRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RefAggSmtRepository::class)
 */
class RefAggSmt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="refAggSmts")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBilan::class, inversedBy="refAggSmts")
     */
    private $TypeBilan;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $surlignee;


    public function __toString()
    {
        return $this->libelle;
    }   

    public function getId(): ?int
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
        return $this->TypeBilan;
    }

    public function setTypeBilan(?TypeBilan $TypeBilan): self
    {
        $this->TypeBilan = $TypeBilan;

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

    public function getSurlignee(): ?bool
    {
        return $this->surlignee;
    }

    public function setSurlignee(?bool $surlignee): self
    {
        $this->surlignee = $surlignee;

        return $this;
    }

    public function isSurlignee(): ?bool
    {
        return $this->surlignee;
    }

   

}
