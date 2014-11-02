<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

/**
 * VendorHandler
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class VendorHandler implements VendorHandlerInterface
{
    /**
     * Vendor fully-qualified class name
     *
     * @var string
     */
    protected $vendorFqcn;

    /**
     * Organization Handler
     *
     * @var OrganizationHandlerInterface
     */
    protected $oh;

    /**
     * EntityManager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  string $vendorFqcn
     * @param  OrganizationHandlerInterface $oh
     * @param  \Doctrine\ORM\EntityManager $em
     */
    public function __construct(
        $vendorFqcn,
        OrganizationHandlerInterface $oh,
        \Doctrine\ORM\EntityManager $em
    )
    {
        $this->vendorFqcn = $vendorFqcn;
        $this->oh = $oh;
        $this->em = $em;
    }

    /**
     * Create new Vendor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @return Vendor
     */
    public function createVendor()
    {
        $vendor = new $this->vendorFqcn();
        $vendor->setOrganization($oh->getOrganization());

        return $vendor;
    }

    /**
     * Find Vendor for name
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  string  $name
     *
     * @return Vendor
     */
    public function findVendorForName($name)
    {
        return $this->em
            ->getRepository($this->vendorFqcn)
            ->findOneBy(array(
                'name' => $name,
                'organization' => $this->oh->getOrganization()
            ))
        ;
    }
}
