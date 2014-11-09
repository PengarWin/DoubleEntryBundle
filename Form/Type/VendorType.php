<?php

/*
 * This file is part of the Phospr DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phospr\DoubleEntryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * VendorType
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class VendorType extends AbstractType
{
    /**
     * Build the form
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('defaultOffsetAccount')
            ->add('defaultJournalDescription')
            ->add('defaultJournalCreditAmount')
            ->add('defaultJournalDebitAmount')
            ->add('save', 'submit', array('label' => $options['label']))
            ->setAction($options['action'])
        ;
    }

    /**
     * Get the name for the HTTP parameter
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function getName()
    {
        return 'vendor';
    }
}
