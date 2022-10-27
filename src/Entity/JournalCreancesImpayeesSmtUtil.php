<?php

namespace App\Entity;

use App\Repository\JournalCreancesImpayeesSmtUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JournalCreancesImpayeesSmtUtilRepository::class)
 * @ORM\Table(name="`cuci_journal_des_creances_impayee_util_smt`")
 */
class JournalCreancesImpayeesSmtUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=JournalCreancesImpayeesSmt::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="journalCreancesImpayeesSmtUtil")
     */
    private $journalCreancesImpayeesSmts;

    public function __construct()
    {
        $this->journalCreancesImpayeesSmts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, JournalCreancesImpayeesSmt>
     */
    public function getJournalCreancesImpayeesSmts(): Collection
    {
        return $this->journalCreancesImpayeesSmts;
    }

    public function addJournalCreancesImpayeesSmt(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt): self
    {
        if (!$this->journalCreancesImpayeesSmts->contains($journalCreancesImpayeesSmt)) {
            $this->journalCreancesImpayeesSmts[] = $journalCreancesImpayeesSmt;
            $journalCreancesImpayeesSmt->setJournalCreancesImpayeesSmtUtil($this);
        }

        return $this;
    }

    public function removeJournalCreancesImpayeesSmt(JournalCreancesImpayeesSmt $journalCreancesImpayeesSmt): self
    {
        if ($this->journalCreancesImpayeesSmts->removeElement($journalCreancesImpayeesSmt)) {
            // set the owning side to null (unless already changed)
            if ($journalCreancesImpayeesSmt->getJournalCreancesImpayeesSmtUtil() === $this) {
                $journalCreancesImpayeesSmt->setJournalCreancesImpayeesSmtUtil(null);
            }
        }

        return $this;
    }
}
