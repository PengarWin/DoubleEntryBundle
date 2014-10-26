<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Criteria;

/**
 * AccountHandler
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2014-10-19
 *
 * @ORM\MappedSuperclass
 */
class AccountHandler
{
    /**
     * Account class name
     *
     * @var string
     */
    protected $accountClassName;

    /**
     * OrganizationHandler
     *
     * @var OrganizationHandlerInterface
     */
    protected $organizationHandler;

    /**
     * EntityManager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-23
     *
     * @param  string $accountClassName
     * @param  OrganizationHandlerInterface $organizationHandler
     * @param  \Doctrine\ORM\EntityManager $em
     */
    public function __construct(
        $accountClassName,
        OrganizationHandlerInterface $organizationHandler,
        \Doctrine\ORM\EntityManager $em
    )
    {
        $this->accountClassName = $accountClassName;
        $this->organizationHandler = $organizationHandler;
        $this->em = $em;
    }

    /**
     * Get chart of accounts for current Organization
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-23
     *
     * @return Account
     */
    public function getChartOfAccounts()
    {
        $organization = $this->organizationHandler->getOrganization();

        if (!$organization->getChartOfAccounts()) {
            $chart = $this->createChartOfAccounts($organization);

            $this->em->persist($organization);
            $this->em->flush();
        }

        return $organization->getChartOfAccounts();
    }

    /**
     * Create new chart of accounts
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-19
     *
     * @param  OrganizationInterface $organization
     *
     * @return Account
     */
    public function createChartOfAccounts(OrganizationInterface $organization)
    {
        $account = $this->accountClassName;

        $chart = new $account($organization->getName());
        $organization->setChartOfAccounts($chart);

        $chart->addChild($assets = new $account('Assets'));
        $assets->addChild($bank = new $account('Bank'));
        $bank->addChild($checking = new $account('Checking'));

        $chart->addChild($equity = new $account('Equity'));
        $equity->addChild($opening = new $account('Opening Balance'));

        $chart->addChild($expenses = new $account('Expenses'));
        $expenses->addChild($food = new $account('Food'));
        $expenses->addChild($auto = new $account('Auto'));
        $auto->addChild($gas = new $account('Gas'));
        $expenses->addChild($childcare = new $account('Childcare'));

        $chart->addChild($income = new $account('Income'));
        $income->addChild($salary = new $account('Salary'));

        $chart->addChild($liabilities = new $account('Liabilities'));
        $liabilities->addChild($cc = new $account('Credit Cards'));

        return $chart;
    }

    /**
     * Create Account tree from segmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-19
     *
     * @param  AccountInterface    $chart
     * @param  AccountSegmentation $segmentation
     */
    public function getAccountFromSegmentation(
        AccountInterface $chart,
        $segmentation
    )
    {
        $segments = explode(':', $segmentation);

        $account = $chart;

        foreach ($segments as $segment) {
            $parent = $account;

            if (!$account = $account->findChildForName($segment)) {
                $account = new $this->accountClassName($segment);
                $parent->addChild($account);
            }
        }

        return $account;
    }

    /**
     * Render Account tree as a multi-level array
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-26
     *
     * @param  AccountInterface $account
     *
     * @return array
     */
    public function renderArray(AccountInterface $account)
    {
        $array = array(
            'name' => $account->getName(),
        );

        foreach ($account->getChildren() as $child) {
            $array['children'][] = $this->renderArray($child);
        }

        return $array;
    }
}
