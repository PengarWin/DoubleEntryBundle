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
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Organization
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2014-10-21
 *
 * @ORM\MappedSuperclass
 */
abstract class Organization
{
    /**
     * id
     */
    protected $id;

    /**
     * @var AccountInterface
     */
    protected $chartOfAccounts;

    /**
     * @var ArrayCollection|AccountInterface
     */
    protected $many;

    /**
     * @var ArrayCollection|AdvancedUserInterface
     */
    protected $users;

    /**
     * @var ArrayCollection|VendorInterface
     */
    protected $vendors;

    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=30, unique=false)
     */
    protected $slug;

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
     * @since  2014-10-21
     *
     * @param  string $name
     */
    public function __construct($name = null)
    {
        if ($name) {
            $this->setName($name);
        }

        $this->chartsOfAccounts = new ArrayCollection();
        $this->users            = new ArrayCollection();
    }

    /**
     * __toString()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
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
     * @since  2014-10-21
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set chartOfAccounts
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @param  AccountInterface $chartOfAccounts
     *
     * @return Account
     */
    public function setChartOfAccounts(AccountInterface $chartOfAccounts)
    {
        $this->chartOfAccounts = $chartOfAccounts;
        $chartOfAccounts->setOrganization($this);

        return $this;
    }

    /**
     * Get chartOfAccounts
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @return Account
     */
    public function getChartOfAccounts()
    {
        return $this->chartOfAccounts;
    }

    /**
     * Add account
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @param  Account $account
     *
     * @return Organization
     */
    public function addAccount(Account $account)
    {
        $this->accounts->add($account);
        $account->addOrganization($this);

        return $this;
    }

    /**
     * Remove account
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @param  Account $account
     */
    public function removeAccount(Account $account)
    {
        $this->accounts->remove($account);
    }

    /**
     * Get accounts
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @return ArrayCollection|Account
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Add user
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @param  AdvancedUserInterface $user
     *
     * @return Organization
     */
    public function addUser(AdvancedUserInterface $user)
    {
        $this->users->add($user);
        $user->addOrganization($this);

        return $this;
    }

    /**
     * Remove user
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @param  AdvancedUserInterface $user
     */
    public function removeUser(AdvancedUserInterface $user)
    {
        $this->users->remove($user);
    }

    /**
     * Get users
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @return ArrayCollection|User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add vendor
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-27
     *
     * @param  VendorInterface $vendor
     *
     * @return Organization
     */
    public function addVendor(VendorInterface $vendor)
    {
        $this->vendors->add($vendor);
        $vendor->setOrganization($this);

        return $this;
    }

    /**
     * Remove vendor
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-27
     *
     * @param  VendorInterface $vendor
     */
    public function removeVendor(VendorInterface $vendor)
    {
        $this->vendors->remove($vendor);
    }

    /**
     * Get vendors
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-27
     *
     * @return ArrayCollection|Vendor
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * Set name
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-21
     *
     * @param  string $name
     *
     * @return Organization
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
     * @since  2014-10-21
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
     * @since  2014-10-21
     *
     * @param  string $slug
     *
     * @return Organization
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
     * @since  2014-10-21
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
     * @since  2014-10-21
     *
     * @param  \DateTime $createdAt
     *
     * @return Organization
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
     * @since  2014-10-21
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
     * @since  2014-10-21
     *
     * @param \DateTime $updatedAt
     *
     * @return Organization
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
     * @since  2014-10-21
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
