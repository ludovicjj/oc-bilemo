<?php

namespace App\Domain\Common;

use App\Domain\Common\Exceptions\ProcessorErrorsHttp;
use App\Responders\JsonResponder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Domain\Common\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
            case ProcessorErrorsHttp::class:
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
            JsonResponder::response(
                json_encode($exception->getErrors()),
                $exception->getStatusCode()
            )
        );
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    private function processHttpException(GetResponseForExceptionEvent $event)
    {
        /** @var HttpException $exception */
        $exception = $event->getException();
        $event->setResponse(
            JsonResponder::response(
                json_encode(['message' => $exception->getMessage()]),
                $exception->getStatusCode()
            )
        );
    }
}
