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
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2014-10-23
 */
class OrganizationHandler
{
    /**
     * SecurityContext
     *
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-23
     *
     * @param  \Symfony\Component\Security\Core\SecurityContext $securityContext
     */
    public function __construct(
        \Symfony\Component\Security\Core\SecurityContext $securityContext
    )
    {
        $this->securityContext = $securityContext;
    }

    /**
     * Get the Organization for the current context
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-23
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
    * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
    * @since  2014-10-23
    *
    * @return User
    */
    public function getUser()
    {
        return $this->securityContext->getToken()->getUser();
    }
}
