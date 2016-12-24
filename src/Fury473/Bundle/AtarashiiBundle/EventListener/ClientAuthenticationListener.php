<?php

namespace Fury473\Bundle\AtarashiiBundle\EventListener;

use EightPoints\Bundle\GuzzleBundle\Events\GuzzleEventListenerInterface;
use EightPoints\Bundle\GuzzleBundle\Events\PreTransactionEvent;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ClientAuthenticationListener
 * @author Olivier Haag <olivierhaag92@gmail.com>
 */
class ClientAuthenticationListener implements GuzzleEventListenerInterface
{

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $serviceName;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onPreTransaction(PreTransactionEvent $event)
    {
        if ($this->hasCredentials()) {
            $request = $event->getTransaction()->withHeader('Authorization', $this->getCredentials());
            $event->setTransaction($request);
        }
    }

    public function hasCredentials()
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request->getUser() and $request->getPassword();
    }

    public function getCredentials()
    {
        $request = $this->requestStack->getCurrentRequest();
        return 'Basic ' . base64_encode($request->getUser() . ":" . $request->getPassword());
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }
}