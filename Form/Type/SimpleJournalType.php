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
 * SimpleJournalType
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class SimpleJournalType extends AbstractType
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
            ->add('date', 'date', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => array(
                    'size' => 5,
                )
            ))
            ->add('chequeNumber', 'number', array(
                'required' => false,
                'attr' => array(
                    'size' => 1,
                )
            ))
            ->add('vendor', 'vendor_selector')
            ->add('description', null, array(
                'attr' => array(
                    'size' => 10,
                )
            ))
            ->add('offsetAccount', 'account_selector')
            ->add('creditAmount', 'number', array(
                'attr' => array(
                    'size' => 2,
                )
            ))
            ->add('debitAmount', 'number', array(
                'attr' => array(
                    'size' => 2,
                )
            ))
            ->add('save', 'submit', array('label' => 'Create'))
        ;
    }

    public function getName()
    {
        return 'simple_journal';
    }
}
