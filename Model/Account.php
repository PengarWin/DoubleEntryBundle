<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ArrayCollection|AccountInterface
     */
    protected $children;

    /**
     * postings
     */
    protected $postings;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $balance = 0;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=50, unique=false)
     */
    protected $slug;

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
     * @return ArrayCollection|PostingInterface
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
     * Set balance
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @param  float $balance
     *
     * @return Account
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-09
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
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
}
