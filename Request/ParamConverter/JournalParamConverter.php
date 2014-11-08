<?php

namespace PengarWin\DoubleEntryBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PengarWin\DoubleEntryBundle\Model\JournalHandlerInterface;

/**
 * JournalParamConverter
 *
 * @author Tom Haskins-Vaughan <tom@tomhv.uk>
 * @since  0.8.0
 */
class JournalParamConverter implements ParamConverterInterface
{
    /**
     * @var JournalHandlerInterface
     */
    private $jh;

    /**
     * Constructor
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  JournalHandlerInterface $jh
     */
    public function __construct(JournalHandlerInterface $jh)
    {
        $this->jh = $jh;
    }

    /**
     * Stores the object in the request
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        try {
            $journal = $this->jh
                ->findJournalForId($request->attributes->get('id'))
            ;

            $request->attributes->set($configuration->getName(), $journal);

            return true;
        } catch (\Doctrine\ORM\NoResultException $e) {
            throw new NotFoundHttpException(sprintf(
                'No Journal found for id "%s"',
                $request->attributes->get('id')
            ));
        }
    }

    /**
     * Checks if the object is supported.
     *
     * @author Tom Haskins-Vaughan <tom@tomhv.uk>
     * @since  0.8.0
     *
     * @param  ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return ($this->jh->getJournalFqcn() === $configuration->getClass());
    }
}
