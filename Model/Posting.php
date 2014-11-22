<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Phospr\DoubleEntryBundle\Exception\JournalImbalanceException;

/**
 * Posting
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 *
 * @ORM\MappedSuperclass
 */
abstract class Posting
{
    /**
     * id
     */
    protected $id;

    /**
     * @var OrganizationInterface
     */
    protected $organization;

    /**
     * @var AccountInterface
     */
    protected $account;

    /**
     * @var JournalInterface
     */
    protected $journal;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $amount = 0;

    /**
     * Do not map in subclass
     *
     * @var float
     */
    protected $calculatedBalance = 0;

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
     * @ORM\Column(type="datetime", name="posted_at", nullable=true)
     */
    protected $postedAt;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  AccountInterface $account
     * @param  float            $amount
     */
    public function __construct(AccountInterface $account = null, $amount = null)
    {
        if (null !== $account) {
            $this->setAccount($account);
        }

        if (null !== $amount) {
            $this->setAmount($amount);
        }
    }

    /**
     * Get id
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set organization
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  OrganizationInterface $organization
     *
     * @return Organization
     */
    public function setOrganization(OrganizationInterface $organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set amount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set calculatedBalance
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  float $calculatedBalance
     */
    public function setCalculatedBalance($calculatedBalance)
    {
        $this->calculatedBalance = $calculatedBalance;
    }

    /**
     * Get calculatedBalance
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return float
     */
    public function getCalculatedBalance()
    {
        return $this->calculatedBalance;
    }

    /**
     * Set account
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  AccountInterface $account
     */
    public function setAccount(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Get account
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set journal
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  JournalInterface $journal
     */
    public function setJournal(JournalInterface $journal)
    {
        $this->journal = $journal;
    }

    /**
     * Get journal
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Journal
     */
    public function getJournal()
    {
        return $this->journal;
    }

    /**
     * Set createdAt
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
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
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
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
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
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
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set postedAt
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  \DateTime $postedAt
     *
     * @return Journal
     */
    public function setPostedAt(\DateTime $postedAt)
    {
        $this->postedAt = $postedAt;

        return $this;
    }

    /**
     * Get postedAt
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return \DateTime
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * post()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function post()
    {
        $this->setPostedAt(new \DateTime());

        $this->getAccount()->setPostedBalance(
            $this->getAccount()->getPostedBalance() + $this->getAmount()
        );
    }

    /**
     * Get offset posting
     *
     * If this Posting's Journal has only two Postings, then return the offset
     * Posting
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     * @todo   Use better Exception class
     *
     * @return Posting
     */
    public function getOffsetPosting()
    {
        $this->getJournal()->assertIsSimpleJournal();

        foreach ($this->getJournal()->getPostings() as $posting) {
            if ($posting != $this) {
                return $posting;
            }
        }
    }

    /**
     * Get creditAmount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return float
     */
    public function getCreditAmount()
    {
        if (0.00001 < $this->getAmount()) {
            return $this->getAmount();
        }
    }

    /**
     * Get debitAmount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return float
     */
    public function getDebitAmount()
    {
        if (-0.00001 > $this->getAmount()) {
            return abs($this->getAmount());
        }
    }

    /**
     * Ensure zero sum - the amount of all Postings must add up to zero
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function ensureZeroSumOfPostings()
    {
        $postingBalance = 0;

        foreach ($this->getJournal()->getPostings() as $posting) {
            $postingBalance += $posting->getAmount();
        }

        if (0.00001 < abs($postingBalance)) {
            throw new JournalImbalanceException(sprintf(
                'Posting balance must be zero; %f given',
                $postingBalance
            ));
        }
    }
}
