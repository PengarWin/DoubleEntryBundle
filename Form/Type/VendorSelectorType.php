<?php

namespace PengarWin\DoubleEntryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PengarWin\DoubleEntryBundle\Model\VendorHandlerInterface;
use PengarWin\DoubleEntryBundle\Form\DataTransformer\VendorToNameTransformer;

/**
 * VendorSelectorType
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class VendorSelectorType extends AbstractType
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
        $builder->addModelTransformer(new VendorToNameTransformer($this->vh));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected vendor does not exist',
            'attr' => array('class' => $this->getName()),
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'vendor_selector';
    }
}
