<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

/**
 * PostingHandlerInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
interface PostingHandlerInterface
{
    /**
     * Get accountFqcn
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     */
    public function getPostingFqcn();

    /**
     * Create new Posting
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @return Posting
     */
    public function createPosting();

    /**
     * Find Posting for id
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  int $id
     *
     * @return Posting
     */
    public function findPostingForId($id);
}
