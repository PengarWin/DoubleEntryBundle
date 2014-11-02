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
use Doctrine\ORM\EntityManager;
use PengarWin\DoubleEntryBundle\Model\VendorHandlerInterface;

/**
 * VendorToNameTransformer
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class VendorToNameTransformer implements DataTransformerInterface
{
    /**
     * Vendor Handler
     *
     * @var \PengarWin\DoubleEntryBundle\Model\VendorHandlerInterface
     */
    protected $vh;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param VendorHandlerInterface $vh
     */
    public function __construct(VendorHandlerInterface $vh)
    {
        $this->vh = $vh;
    }

    /**
     * Transforms an Vendor to its name
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  Vendor|null $vendor
     *
     * @return string
     */
    public function transform($vendor)
    {
        if (null === $vendor) {
            return '';
        }

        return $vendor->getName();
    }

    /**
     * Transforms a string (name) to an object (Vendor).
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  string $name
     *
     * @return Vendor|null
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }

        $vendor = $this->vh->findVendorForName($name);

        if (null === $vendor) {
            $vendor = $this->vh->createVendor($name);
        }

        return $vendor;
    }
}
