<?php

namespace PengarWin\DoubleEntryBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PengarWin\DoubleEntryBundle\Model\AccountHandlerInterface;

/**
 * AccountParamConverter
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  1.0.0
 */
class AccountParamConverter implements ParamConverterInterface
{
    /**
     * @var AccountHandlerInterface
     */
    private $ah;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  AccountHandlerInterface $ah
     */
    public function __construct(AccountHandlerInterface $ah)
    {
        $this->ah = $ah;
    }

    /**
     * Stores the object in the request
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $account = $this->ah
            ->findAccountForPath($request->attributes->get('path'))
        ;

        if (!$account) {
            throw new NotFoundHttpException(sprintf(
                'No Account found for path "%s"',
                $request->attributes->get('path')
            ));
        }

        $request->attributes->set($configuration->getName(), $account);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  1.0.0
     *
     * @param  ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return ($this->ah->getAccountFqcn() === $configuration->getClass());
    }
}
