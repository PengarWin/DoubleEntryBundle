<?php

namespace PengarWin\DoubleEntryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PengarWin\DoubleEntryBundle\Model\AccountHandlerInterface;
use PengarWin\DoubleEntryBundle\Form\DataTransformer\AccountToSegmentationTransformer;

/**
 * AccountSelectorType
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class AccountSelectorType extends AbstractType
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
     * Build the form
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  FormBuilderInterface $builder
     * @param  array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new AccountToSegmentationTransformer($this->ah)
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected account does not exist',
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'account_selector';
    }
}
