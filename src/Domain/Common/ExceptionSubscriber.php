<?php

namespace App\Domain\Common;

use App\Responders\ErrorResponder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Domain\Common\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            case AccessDeniedHttpException::class:
                $this->processHttpException($event);
                break;
            case NotFoundHttpException::class:
                $this->processHttpException($event);
                break;
        }
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function processValidatorException(GetResponseForExceptionEvent $event)
    {
        /** @var ValidatorException $exception */
        $exception = $event->getException();
        $event->setResponse(
            ErrorResponder::response(
                (string) json_encode($exception->getErrors()),
                $exception->getStatusCode()
            )
        );
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    private function processHttpException(GetResponseForExceptionEvent $event)
    {
        /** @var AccessDeniedHttpException|NotFoundHttpException $exception */
        $exception = $event->getException();
        $event->setResponse(
            ErrorResponder::response(
                (string) json_encode(['message' => $exception->getMessage()]),
                $exception->getStatusCode()
            )
        );
    }
}
