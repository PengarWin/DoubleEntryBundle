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
use PengarWin\DoubleEntryBundle\Model\PostingHandlerInterface;

/**
 * PostingType
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class PostingType extends AbstractType
{
    /**
     * PostingHandler
     *
     * @var PostingHandlerInterface
     */
    protected $ph;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  PostingHandlerInterface $ph
     */
    public function __construct(PostingHandlerInterface $ph)
    {
        $this->ph = $ph;
    }

    /**
     * Build the form
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account', 'account_selector')
            ->add('amount')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->ph->getPostingFqcn(),
        ));
    }

    /**
     * Get the name for the HTTP parameter
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     */
    public function getName()
    {
        return 'posting';
    }
}
