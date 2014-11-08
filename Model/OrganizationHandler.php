<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

/**
 * OrganizationHandler
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class OrganizationHandler implements OrganizationHandlerInterface
{
    /**
     * Organization fully-qualified class name
     *
     * @var string
     */
    protected $organizationFqcn;

    /**
     * SecurityContext
     *
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

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
     * @param  \Symfony\Component\Security\Core\SecurityContext $securityContext
     * @param  \Doctrine\ORM\EntityManager $em
     */
    public function __construct(
        $organizationFqcn,
        \Symfony\Component\Security\Core\SecurityContext $securityContext,
        \Doctrine\ORM\EntityManager $em
    )
    {
        $this->securityContext = $securityContext;
        $this->em = $em;
    }

    /**
     * Get the Organization for the current context
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->getUser()->getDefaultOrganization();
    }

    /**
     * Get current User
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @return User
     */
    protected function getUser()
    {
        return $this->securityContext->getToken()->getUser();
    }
}
