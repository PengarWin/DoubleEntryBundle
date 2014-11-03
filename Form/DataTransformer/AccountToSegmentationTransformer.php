<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use PengarWin\DoubleEntryBundle\Model\AccountHandlerInterface;

/**
 * AccountToSegmentationTransformer
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class AccountToSegmentationTransformer implements DataTransformerInterface
{
    /**
     * Account Handler
     *
     * @var \PengarWin\DoubleEntryBundle\Model\AccountHandlerInterface
     */
    protected $ah;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param AccountHandlerInterface $ah
     */
    public function __construct(AccountHandlerInterface $ah)
    {
        $this->ah = $ah;
    }

    /**
     * Transforms an Account to its segmentation
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  Account|null $account
     *
     * @return string
     */
    public function transform($account)
    {
        if (null === $account) {
            return '';
        }

        return $account->getSegmentation();
    }

    /**
     * Transforms a string (segmentation) to an object (Account).
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  string $segmentation
     *
     * @return Account|null
     */
    public function reverseTransform($segmentation)
    {
        if (!$segmentation) {
            return null;
        }

        $account = $this->ah->findAccountForSegmentation($segmentation);

        if (null === $segmentation) {
            $account = $this->ah->createAccountForSegmentation($segmentation);
        }

        return $account;
    }
}
