<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

/**
 * AccountHandlerInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
interface AccountHandlerInterface
{
    /**
     * Get accountFqcn
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function getAccountFqcn();

    /**
     * Create new Account
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Account
     */
    public function createAccount();

    /**
     * Find Account for segmentation
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  string  $segmentation
     *
     * @return Account
     */
    public function findAccountForSegmentation($name);

    /**
     * Find Account for path
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  string  $path
     *
     * @return Account
     */
    public function findAccountForPath($path);
}
