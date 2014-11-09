<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

/**
 * JournalHandler
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class JournalHandler implements JournalHandlerInterface
{
    /**
     * Journal class name
     *
     * @var string
     */
    protected $journalFqcn;

    /**
     * OrganizationHandler
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
     * @since  0.8.0
     *
     * @param  string $journalFqcn
     * @param  OrganizationHandlerInterface $oh
     * @param  \Doctrine\ORM\EntityManager $em
     */
    public function __construct(
        $journalFqcn,
        OrganizationHandlerInterface $oh,
        \Doctrine\ORM\EntityManager $em
    )
    {
        $this->journalFqcn = $journalFqcn;
        $this->oh = $oh;
        $this->em = $em;
    }

    /**
     * Get journalFqcn
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return string
     */
    public function getJournalFqcn()
    {
        return $this->journalFqcn;
    }

    /**
     * Get repository
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    protected function getRepository()
    {
        return $this->em
            ->getRepository($this->journalFqcn)
        ;
    }

    /**
     * Find Journal for id
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  int $id
     *
     * @return Journal
     */
    public function findJournalForId($id)
    {
        $dql = '
            SELECT    j,p
            FROM      %s j
            LEFT JOIN j.postings p
            WHERE     j.id = :id
            AND       j.organization = :organization
        ';

        return $this->em
            ->createQuery(sprintf($dql, $this->journalFqcn))
            ->setParameter('id', $id)
            ->setParameter('organization', $this->oh->getOrganization())
            ->getSingleResult()
        ;
    }

    /**
     * Create new Journal
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Journal
     */
    public function createJournal()
    {
        $journal = new $this->journalFqcn();
        $journal->setOrganization($this->oh->getOrganization());

        return $journal;
    }
}
