<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

/**
 * VendorHandlerInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
interface VendorHandlerInterface
{
    /**
     * Create new Vendor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Vendor
     */
    public function createVendor();

    /**
     * Find Vendor for name
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  string  $name
     *
     * @return Vendor
     */
    public function findVendorForName($name);

    /**
     * Find Vendor for slug
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  string  $slug
     *
     * @return Vendor
     */
    public function findVendorForSlug($slug);
}
