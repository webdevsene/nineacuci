<?php

namespace App\Entity;

use App\Repository\JournalTresorerieSmtUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JournalTresorerieSmtUtilRepository::class)
 * @ORM\Table(name="`cuci_journal_de_tresorerie_smt_util`")
 */
class JournalTresorerieSmtUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=JournalTresorerie::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="journalTresorerieSmtUtil")
     */
    private $journalTresoreries;

    public function __construct()
    {
        $this->journalTresoreries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, JournalTresorerie>
     */
    public function getJournalTresoreries(): Collection
    {
        return $this->journalTresoreries;
    }

    public function addJournalTresorery(JournalTresorerie $journalTresorery): self
    {
        if (!$this->journalTresoreries->contains($journalTresorery)) {
            $this->journalTresoreries[] = $journalTresorery;
            $journalTresorery->setJournalTresorerieSmtUtil($this);
        }

        return $this;
    }

    public function removeJournalTresorery(JournalTresorerie $journalTresorery): self
    {
        if ($this->journalTresoreries->removeElement($journalTresorery)) {
            // set the owning side to null (unless already changed)
            if ($journalTresorery->getJournalTresorerieSmtUtil() === $this) {
                $journalTresorery->setJournalTresorerieSmtUtil(null);
            }
        }

        return $this;
    }
}
