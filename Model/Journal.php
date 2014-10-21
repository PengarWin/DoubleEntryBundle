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
use PengarWin\DoubleEntryBundle\Exception\JournalImbalanceException;
use PengarWin\DoubleEntryBundle\Exception\NotSimpleJournalException;

/**
 * Journal
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2014-10-09
 *
 * @ORM\MappedSuperclass
 */
abstract class Journal
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ArrayCollection|PostingInterface
     */
    protected $postings;

    /**
     * Do not map in sub class
     *
     * @var AccountInterface
     */
    protected $offsetAccount;

    /**
     * @var VendorInterface
     */
    protected $vendor;

    /**
     * @var string
     */
    protected $proposedVendorName = '';

    /**
     * @var string
     */
    protected $proposedOffsetAccountSegmentation = '';

    /**
     * Do not map in sub class
     *
     * @var float
     */
    protected $creditAmount = 0;

    /**
     * Do not map in sub class
     *
     * @var float
     */
    protected $debitAmount = 0;

    /**
     * @ORM\Column(type="string")
     */
    protected $description = '';

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

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
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     */
    public function __construct()
    {
        $this->postings = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add posting
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  PostingInterface $posting
     */
    public function addPosting(PostingInterface $posting)
    {
        $this->postings->add($posting);
        $posting->setJournal($this);
    }

    /**
     * Get postings
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return ArrayCollection|Posting
     */
    public function getPostings()
    {
        return $this->postings;
    }

    /**
     * Set offsetAccount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  AccountInterface $offsetAccount
     */
    public function setOffsetAccount(AccountInterface $offsetAccount)
    {
        $this->offsetAccount = $offsetAccount;
    }

    /**
     * Get offsetAccount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return Account
     */
    public function getOffsetAccount()
    {
        return $this->offsetAccount;
    }

    /**
     * Ensure zero sum - the amount of all Postings must add up to zero
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @ORM\PrePersist
     */
    public function ensureZeroSumOfPostings()
    {
        $postingBalance = 0;

        foreach ($this->getPostings() as $posting) {
            $postingBalance += $posting->getAmount();
        }

        if (0.00001 < abs($postingBalance)) {
            throw new JournalImbalanceException(sprintf(
                'Posting balance must be zero; %f given',
                $postingBalance
            ));
        }
    }

    /**
     * Remove posting
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  PostingInterface $posting
     */
    public function removePosting(PostingInterface $posting)
    {
        $this->postings->removeElement($posting);
    }

    /**
     * Set description
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  string $description
     *
     * @return Journal
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set date
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param \DateTime $date
     *
     * @return Journal
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set createdAt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
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
     * @since  2014-10-11
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
     * @since  2014-10-11
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
     * @since  2014-10-11
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
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
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
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
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
     * Post all Postings for this Journal
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-02-09
     */
    public function post()
    {
        $this->setPostedAt(new \DateTime());

        $this->ensureZeroSumOfPostings();

        foreach ($this->getPostings() as $posting) {
            $posting->post();
        }
    }

    /**
     * debit()
     *
     * Debits the given account by the given account. Takes into account
     * what type of account it is (Asset, Liability, Income, Expense)
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-20
     *
     * @param  \HarvestCloud\CoreBundle\Entity\Account $account
     * @param  decimal $amount
     *
     * @return \HarvestCloud\CoreBundle\Entity\Posting
     */
    public function debit(Account $account, $amount)
    {
        // Income and Liabilities need the sign changed
        if ($account->isIncome() || $account->isLiability()) {
          $amount = -1*$amount;
        }

        $posting = new Posting();
        $posting->setAccount($account);
        $posting->setAmount($amount);

        $this->addPosting($posting);

        return $posting;
    }

    /**
     * credit()
     *
     * Credits the given account by the given account. Takes into account
     * what type of account it is (Asset, Liability, Income, Expense)
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-20
     *
     * @param  \HarvestCloud\CoreBundle\Entity\Account $account
     * @param  decimal $amount
     *
     * @return \HarvestCloud\CoreBundle\Entity\Posting
     */
    public function credit(Account $account, $amount)
    {
        // Income and Liabilities need the sign changed
        if ($account->isIncome() || $account->isLiability()) {
          $amount = -1*$amount;
        }

        $posting = new Posting();
        $posting->setAccount($account);
        $posting->setAmount($amount);

        $this->addPosting($posting);

        return $posting;
    }

    /**
     * Set creditAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-12
     *
     * @param  float $creditAmount
     */
    public function setCreditAmount($creditAmount)
    {
        $this->creditAmount = $creditAmount;
    }

    /**
     * Get creditAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-12
     *
     * @return float
     */
    public function getCreditAmount()
    {
        return $this->creditAmount;
    }

    /**
     * Set debitAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-12
     *
     * @param  float $debitAmount
     */
    public function setDebitAmount($debitAmount)
    {
        $this->debitAmount = $debitAmount;
    }

    /**
     * Get debitAmount
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-12
     *
     * @return float
     */
    public function getDebitAmount()
    {
        return $this->debitAmount;
    }

    /**
     * Assert that this Journal is a simple Journal, i.e. has exactly two
     * Postings
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     */
    public function assertIsSimpleJournal()
    {
        if (2 != $this->getPostings()->count()) {
            throw new \Exception(sprintf(
                'Journal has %d Postings and is not a simple Journal',
                $this->getPostings()->count()
            ));
        }
    }

    /**
     * Checks whether this Journal is a simple Journal, i.e. has exactly two
     * Postings
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return bool
     */
    public function isSimpleJournal()
    {
        try {
            $this->assertIsSimpleJournal();

            return true;
        } catch (NotSimpleJournalException $e) {
            return false;
        }
    }

    /**
     * Set vendor
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-14
     *
     * @param  VendorInterface $vendor
     */
    public function setVendor(VendorInterface $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get vendor
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-14
     *
     * @return Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set proposedVendorName
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-16
     *
     * @param  string $proposedVendorName
     *
     * @return Journal
     */
    public function setProposedVendorName($proposedVendorName)
    {
        $this->proposedVendorName = $proposedVendorName;

        return $this;
    }

    /**
     * Get proposedVendorName
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-16
     *
     * @return string
     */
    public function getProposedVendorName()
    {
        return $this->proposedVendorName;
    }

    /**
     * Set proposedOffsetAccountSegmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-16
     *
     * @param  string $proposedOffsetAccountSegmentation
     *
     * @return Journal
     */
    public function setProposedOffsetAccountSegmentation($proposedOffsetAccountSegmentation)
    {
        $this->proposedOffsetAccountSegmentation = $proposedOffsetAccountSegmentation;

        return $this;
    }

    /**
     * Get proposedOffsetAccountSegmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-16
     *
     * @return string
     */
    public function getProposedOffsetAccountSegmentation()
    {
        return $this->proposedOffsetAccountSegmentation;
    }
}
