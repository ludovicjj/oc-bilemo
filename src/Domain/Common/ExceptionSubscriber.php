<?php

namespace App\Domain\Common;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Domain\Common\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onProcessException'
        ];
    }

    public function onProcessException(GetResponseForExceptionEvent $event)
    {
        switch (get_class($event->getException())) {
            case ValidatorException::class:
                $this->processValidatorException($event);
                break;
        }
    }

    public function processValidatorException(GetResponseForExceptionEvent $event)
    {
        /** @var ValidatorException $exception */
        $exception = $event->getException();
        $event->setResponse();
    }
}