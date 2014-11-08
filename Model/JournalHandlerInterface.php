<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

/**
 * JournalHandlerInterface
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
interface JournalHandlerInterface
{
    /**
     * Get accountFqcn
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     */
    public function getJournalFqcn();

    /**
     * Create new Journal
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @return Journal
     */
    public function createJournal();

    /**
     * Find Journal for id
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  int $id
     *
     * @return Journal
     */
    public function findJournalForId($id);
}
