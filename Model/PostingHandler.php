<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Model;

/**
 * PostingHandler
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class PostingHandler implements PostingHandlerInterface
{
    /**
     * Posting class name
     *
     * @var string
     */
    protected $postingFqcn;

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
     * @param  string $postingFqcn
     * @param  OrganizationHandlerInterface $oh
     * @param  \Doctrine\ORM\EntityManager $em
     */
    public function __construct(
        $postingFqcn,
        OrganizationHandlerInterface $oh,
        \Doctrine\ORM\EntityManager $em
    )
    {
        $this->postingFqcn = $postingFqcn;
        $this->oh = $oh;
        $this->em = $em;
    }

    /**
     * Get postingFqcn
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return string
     */
    public function getPostingFqcn()
    {
        return $this->postingFqcn;
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
            ->getRepository($this->postingFqcn)
        ;
    }

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
    public function findPostingForId($id)
    {
        $dql = '
            SELECT    p
            FROM      %s p
            WHERE     p.id = :id
            AND       p.organization = :organization
        ';

        return $this->em
            ->createQuery(sprintf($dql, $this->postingFqcn))
            ->setParameter('id', $id)
            ->setParameter('organization', $this->oh->getOrganization())
            ->getSingleResult()
        ;
    }

    /**
     * Create new Posting
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  AccountInterface $account
     * @param  float            $amount
     *
     * @return Posting
     */
    public function createPosting(AccountInterface $account, $amount)
    {
        $posting = new $this->postingFqcn($account, $amount);
        $posting->setOrganization($this->oh->getOrganization());

        return $posting;
    }
}
