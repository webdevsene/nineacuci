<?php

namespace App\Entity;

use App\Repository\JournalDettesPayerSmtUtilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JournalDettesPayerSmtUtilRepository::class)
 * @ORM\Table(name="`cuci_journal_des_dettes_apayer_smt_util`")
 */
class JournalDettesPayerSmtUtil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=JournalDettesPayerSmt::class, fetch="EXTRA_LAZY",orphanRemoval=true,cascade={"persist"}, mappedBy="journalDettesPayerSmtUtil")
     */
    private $journalDettesPayerSmts;

    public function __construct()
    {
        $this->journalDettesPayerSmts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, JournalDettesPayerSmt>
     */
    public function getJournalDettesPayerSmts(): Collection
    {
        return $this->journalDettesPayerSmts;
    }

    public function addJournalDettesPayerSmt(JournalDettesPayerSmt $journalDettesPayerSmt): self
    {
        if (!$this->journalDettesPayerSmts->contains($journalDettesPayerSmt)) {
            $this->journalDettesPayerSmts[] = $journalDettesPayerSmt;
            $journalDettesPayerSmt->setJournalDettesPayerSmtUtil($this);
        }

        return $this;
    }

    public function removeJournalDettesPayerSmt(JournalDettesPayerSmt $journalDettesPayerSmt): self
    {
        if ($this->journalDettesPayerSmts->removeElement($journalDettesPayerSmt)) {
            // set the owning side to null (unless already changed)
            if ($journalDettesPayerSmt->getJournalDettesPayerSmtUtil() === $this) {
                $journalDettesPayerSmt->setJournalDettesPayerSmtUtil(null);
            }
        }

        return $this;
    }
}
