<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

/**
 * VendorInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
interface VendorInterface
{
    /**
     * Get segmentation for defaultOffsetAccount
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.9.2
     *
     * @return string
     */
    public function getDefaultOffsetAccountSegmentation();
}
