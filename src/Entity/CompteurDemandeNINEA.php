<?php

namespace App\Entity;

use App\Repository\CompteurDemandeNINEARepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompteurDemandeNINEARepository::class)
 */
class CompteurDemandeNINEA
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Created_At;

    
    public function __construct()
    {
        
        $this->Created_At=new \DateTime();
        
    }

    public function __toString()
    {
        return $this->id;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->Created_At;
    }

    public function setCreatedAt(\DateTimeInterface $Created_At): self
    {
        $this->Created_At = $Created_At;

        return $this;
    }
}
