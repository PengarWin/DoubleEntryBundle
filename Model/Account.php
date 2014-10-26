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
use Doctrine\Common\Collections\Criteria;

/**
 * Account
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2014-10-09
 *
 * @ORM\MappedSuperclass
 * @Gedmo\Tree(type="nested")
 */
abstract class Account
{
    /**
     * id
     */
    protected $id;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    protected $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    protected $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    protected $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    protected $root;

    /**
     * @var AccountInterface
     */
    protected $parent;

    /**
     * @var OrganizationInterface
     */
    protected $organization;

    /**
     * @var ArrayCollection|AccountInterface
     */
    protected $children;

    /**
     * postings
     */
    protected $postings;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $postedBalance = 0;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=30, unique=false)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $segmentation;

    /**
     * @ORM\Column(length=255)
     */
    protected $path;

    /**
     * @var ArrayCollection|ChequeInterface
     */
    protected $cheques;

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
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  string $name
     */
    public function __construct($name = null)
    {
        if ($name) {
            $this->setName($name);
        }

        $this->postings = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->cheques  = new ArrayCollection();
    }

    /**
     * __toString()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
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
     * @since  2014-10-09
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lft
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @param  integer $lft
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    }

    /**
     * Get lft
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @param  integer $lvl
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * Get lvl
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @param  integer $rgt
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    }

    /**
     * Get rgt
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @param  integer $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * Get root
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @param  AccountInterface $parent
     *
     * @return Account
     */
    public function setParent(AccountInterface $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-10
     *
     * @return Account
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set organization
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
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
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Add child
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  AccountInterface $child
     *
     * @return Account
     */
    public function addChild(AccountInterface $child)
    {
        $this->children->add($child);
        $child->setParent($this);

        return $this;
    }

    /**
     * Remove child
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  AccountInterface $child
     */
    public function removeChild(AccountInterface $child)
    {
        $this->children->remove($child);
    }

    /**
     * Get children
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @return ArrayCollection|Account
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add posting
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  PostingInterface $posting
     *
     * @return Account
     */
    public function addPosting(PostingInterface $posting)
    {
        $this->postings->add($posting);

        return $this;
    }

    /**
     * Remove posting
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  PostingInterface $posting
     */
    public function removePosting(PostingInterface $posting)
    {
        $this->postings->remove($posting);
    }

    /**
     * Get postings
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @return ArrayCollection|Posting
     */
    public function getPostings()
    {
        return $this->postings;
    }

    /**
     * Set name
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  string $name
     *
     * @return Account
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
     * @since  2014-10-09
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set postedBalance
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  float $postedBalance
     *
     * @return Account
     */
    public function setPostedBalance($postedBalance)
    {
        $this->postedBalance = $postedBalance;

        return $this;
    }

    /**
     * Get postedBalance
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @return float
     */
    public function getPostedBalance()
    {
        return $this->postedBalance;
    }

    /**
     * Set slug
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
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
     * @since  2014-10-09
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set path
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @param  string $path
     *
     * @return Account
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set segmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-17
     *
     * @param  string $segmentation
     *
     * @return Account
     */
    public function setSegmentation($segmentation)
    {
        $this->segmentation = $segmentation;

        return $this;
    }

    /**
     * Get segmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-17
     *
     * @return string
     */
    public function getSegmentation()
    {
        return $this->segmentation;
    }

    /**
     * Generate slug, segmentation and path
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-11
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function generateSlugSegmentationAndPath()
    {
        // Set slug for this Account.  The reason we do this here is that
        // the slug listener hasn't been called yet
        $this->setSlug(\Gedmo\Sluggable\Util\Urlizer::urlize($this->name));

        if ($this->getParent()) {
            $account = $this;

            $pathSegments = array($account->getSlug());
            $nameSegments = array($account->getName());

            while ($account->getParent()) {
                $account        = $account->getParent();

                // Don't include root
                if ($account->getParent()) {
                    $pathSegments[] = $account->getSlug();
                    $nameSegments[] = $account->getName();
                }
            }

            $this->setPath(implode('/', array_reverse($pathSegments)));
            $this->setSegmentation(implode(':', array_reverse($nameSegments)));
        } else {
            $this->setPath('/');
            $this->setSegmentation(':');
        }
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
     * Add cheque
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  ChequeInterface $cheque
     *
     * @return Account
     */
    public function addCheque(ChequeInterface $cheque)
    {
        $this->cheques->add($cheque);

        return $this;
    }

    /**
     * Remove cheque
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @param  ChequeInterface $cheque
     */
    public function removeCheque(ChequeInterface $cheque)
    {
        $this->cheques->remove($cheque);
    }

    /**
     * Get cheques
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-13
     *
     * @return ArrayCollection|Cheque
     */
    public function getCheques()
    {
        return $this->cheques;
    }

    /**
     * Get posted Postings
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-15
     *
     * @return ArrayCollection|Posting
     */
    public function getPostedPostings()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->neq('postedAt', null))
            ->orderBy(array('postedAt' => Criteria::ASC))
        ;

        return $this->getPostings()->matching($criteria);
    }

    /**
     * Get unposted Postings
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-15
     *
     * @return ArrayCollection|Posting
     */
    public function getUnpostedPostings()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('postedAt', null))
        ;

        return $this->getPostings()->matching($criteria);
    }

    /**
     * Find a child account by name
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-19
     *
     * @param  string $name
     *
     * @return Account
     */
    public function findChildForName($name)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('name', $name))
        ;

        return $this->getChildren()->matching($criteria)->first();
    }
}
