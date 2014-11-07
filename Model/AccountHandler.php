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
 * @since  1.0.0
 *
 * @ORM\MappedSuperclass
 */
class AccountHandler implements AccountHandlerInterface
{
    /**
     * Account class name
     *
     * @var string
     */
    protected $accountFqcn;

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
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     *
     * @param  string $accountFqcn
     * @param  OrganizationHandlerInterface $oh
     * @param  \Doctrine\ORM\EntityManager $em
     */
    public function __construct(
        $accountFqcn,
        OrganizationHandlerInterface $oh,
        \Doctrine\ORM\EntityManager $em
    )
    {
        $this->accountFqcn = $accountFqcn;
        $this->oh = $oh;
        $this->em = $em;
    }

    /**
     * Get accountFqcn
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     */
    public function getAccountFqcn()
    {
        return $this->accountFqcn;
    }

    /**
     * Get repository
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     */
    protected function getRepository()
    {
        return $this->em
            ->getRepository($this->accountFqcn)
        ;
    }

    /**
     * Get chart of accounts for current Organization
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     *
     * @return Account
     */
    public function getChartOfAccounts()
    {
        $organization = $this->oh->getOrganization();

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
     * @since  1.0.0
     *
     * @param  OrganizationInterface $organization
     *
     * @return Account
     */
    public function createChartOfAccounts(OrganizationInterface $organization)
    {
        $account = $this->accountFqcn;

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
     * Find Account for segmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     *
     * @param  string $segmentation
     */
    public function findAccountForSegmentation($segmentation)
    {
        return $this->getRepository()->findOneBy(array(
            'segmentation' => $segmentation,
            'organization' => $this->oh->getOrganization()
        ));
    }

    /**
     * Find Account for path
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     *
     * @param  string $path
     */
    public function findAccountForPath($path)
    {
        $dql = '
            SELECT    a,p,j,op
            FROM      %s a
            LEFT JOIN a.postings p
            LEFT JOIN p.journal j
            LEFT JOIN j.postings op
            WHERE     a.path = :path
            AND       a.organization = :organization
        ';

        return $this->em
            ->createQuery(sprintf($dql, $this->accountFqcn))
            ->setParameter('path', $path)
            ->setParameter('organization', $this->oh->getOrganization())
            ->getSingleResult()
        ;
    }

    /**
     * Get path for tree
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     *
     * @param  string $path
     */
    public function getTreePath($account)
    {
        return $this->getRepository()->getPath($account);
    }

    /**
     * Create Account tree from segmentation
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
     *
     * @param  AccountInterface    $chart
     * @param  AccountSegmentation $segmentation
     */
    public function createAccountsFromSegmentation($segmentation)
    {
        $segments = explode(':', $segmentation);

        $account = $this->oh->getOrganization()->getChartOfAccounts();

        foreach ($segments as $segment) {
            $parent = $account;

            if (!$account = $account->getChildForName($segment)) {
                $account = new $this->accountFqcn($segment);
                $parent->addChild($account);
            }
        }

        return $account;
    }

    /**
     * Create new Account
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  string  $name
     *
     * @return Account
     */
    public function createAccount($name = null)
    {
        $account = new $this->accountFqcn($name);
        $account->setOrganization($this->oh->getOrganization());

        return $account;
    }

    /**
     * Render Account tree as a multi-level array
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  1.0.0
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
