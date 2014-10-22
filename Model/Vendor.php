<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vendor
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2014-10-13
 *
 * @ORM\MappedSuperclass
 */
abstract class Vendor
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ArrayCollection|JournalInterface
     */
    protected $journals;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @var Account
     */
    protected $defaultOffsetAccount;

    /**
     * @ORM\Column(type="string", name="default_journal_description")
     */
    protected $defaultJournalDescription = '';

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $defaultJournalCreditAmount = 0;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $defaultJournalDebitAmount = 0;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  string $name
     */
    public function __construct($name = null)
    {
        if (null !== $name) {
            $this->setName($name);
        }

        $this->journals = new ArrayCollection();
    }

    /**
     * __toString()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-14
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add journal
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  JournalInterface $journal
     */
    public function addJournal(JournalInterface $journal)
    {
        $this->journals->add($journal);
        $journal->setJournal($this);
    }

    /**
     * Remove journal
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  JournalInterface $journal
     */
    public function removeJournal(JournalInterface $journal)
    {
        $this->journals->removeElement($journal);
    }

    /**
     * Get journals
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return ArrayCollection|Journal
     */
    public function getJournals()
    {
        return $this->journals;
    }

    /**
     * Set name
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  string $name
     *
     * @return Journal
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  string $slug
     *
     * @return Account
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  \DateTime $createdAt
     *
     * @return Journal
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param \DateTime $updatedAt
     *
     * @return Journal
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set defaultOffsetAccount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  AccountInterface $defaultOffsetAccount
     */
    public function setDefaultOffsetAccount(AccountInterface $defaultOffsetAccount)
    {
        $this->defaultOffsetAccount = $defaultOffsetAccount;
    }

    /**
     * Get defaultOffsetAccount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return Account
     */
    public function getDefaultOffsetAccount()
    {
        return $this->defaultOffsetAccount;
    }

    /**
     * Set defaultJournalDescription
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-22
     *
     * @param  string $defaultJournalDescription
     *
     * @return Vendor
     */
    public function setDefaultJournalDescription($defaultJournalDescription)
    {
        $this->defaultJournalDescription = $defaultJournalDescription;

        return $this;
    }

    /**
     * Get defaultJournalDescription
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-22
     *
     * @return string
     */
    public function getDefaultJournalDescription()
    {
        return $this->defaultJournalDescription;
    }

    /**
     * Set defaultJournalCreditAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-22
     *
     * @param  float $defaultJournalCreditAmount
     */
    public function setDefaultJournalCreditAmount($defaultJournalCreditAmount)
    {
        $this->defaultJournalCreditAmount = $defaultJournalCreditAmount;
    }

    /**
     * Get defaultJournalCreditAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-22
     *
     * @return float
     */
    public function getDefaultJournalCreditAmount()
    {
        return $this->defaultJournalCreditAmount;
    }

    /**
     * Set defaultJournalDebitAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-22
     *
     * @param  float $defaultJournalDebitAmount
     */
    public function setDefaultJournalDebitAmount($defaultJournalDebitAmount)
    {
        $this->defaultJournalDebitAmount = $defaultJournalDebitAmount;
    }

    /**
     * Get defaultJournalDebitAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-22
     *
     * @return float
     */
    public function getDefaultJournalDebitAmount()
    {
        return $this->defaultJournalDebitAmount;
    }
}
