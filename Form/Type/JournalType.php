<?php

/*
 * This file is part of the PengarWin DoubleEntryBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PengarWin\DoubleEntryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PengarWin\DoubleEntryBundle\Model\JournalHandlerInterface;

/**
 * JournalType
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class JournalType extends AbstractType
{
    /**
     * JournalHandler
     *
     * @var JournalHandlerInterface
     */
    protected $jh;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  JournalHandlerInterface $jh
     */
    public function __construct(JournalHandlerInterface $jh)
    {
        $this->jh = $jh;
    }

    /**
     * Build the form
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
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
            ->add('description')
            ->add('postings', 'collection', array('type' => new PostingType()))
            ->add('save', 'submit', array('label' => $options['label']))
            ->setAction($options['action'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->jh->getJournalFqcn(),
        ));
    }

    /**
     * Get the name for the HTTP parameter
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     */
    public function getName()
    {
        return 'journal';
    }
}
