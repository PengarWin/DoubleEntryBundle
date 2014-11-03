<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

/**
 * AccountHandlerInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
interface AccountHandlerInterface
{
    /**
     * Create new Account
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @return Account
     */
    public function createAccount();

    /**
     * Find Account for segmentation
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
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
     * @since  1.0.0
     *
     * @param  string  $path
     *
     * @return Account
     */
    public function findAccountForPath($path);
}
