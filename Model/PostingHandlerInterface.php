<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

/**
 * PostingHandlerInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
interface PostingHandlerInterface
{
    /**
     * Get accountFqcn
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function getPostingFqcn();

    /**
     * Create new Posting
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Posting
     */
    public function createPosting();

    /**
     * Find Posting for id
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  int $id
     *
     * @return Posting
     */
    public function findPostingForId($id);
}
