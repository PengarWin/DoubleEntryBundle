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
     * Create new chart of accounts
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2014-10-19
     *
     * @return Account
     */
    public function createChartOfAccounts(AccountInterface $chart)
    {
        $chart->addChild($assets = $chart->createNewAccount('Assets'));
        $assets->addChild($bank = $chart->createNewAccount('Bank'));
        $bank->addChild($checking = $chart->createNewAccount('Checking'));

        $chart->addChild($equity = $chart->createNewAccount('Equity'));
        $equity->addChild($opening = $chart->createNewAccount('Opening Balance'));

        $chart->addChild($expenses = $chart->createNewAccount('Expenses'));
        $expenses->addChild($food = $chart->createNewAccount('Food'));
        $expenses->addChild($auto = $chart->createNewAccount('Auto'));
        $auto->addChild($gas = $chart->createNewAccount('Gas'));
        $expenses->addChild($childcare = $chart->createNewAccount('Childcare'));

        $chart->addChild($income = $chart->createNewAccount('Income'));
        $income->addChild($salary = $chart->createNewAccount('Salary'));

        $chart->addChild($liabilities = $chart->createNewAccount('Liabilities'));
        $liabilities->addChild($cc = $chart->createNewAccount('Credit Cards'));

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
                $account = $chart->createNewAccount($segment);
                $parent->addChild($account);
            }
        }

        return $account;
    }
}
