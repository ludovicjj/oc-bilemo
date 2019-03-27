<?php

namespace App\Domain\Common\Exceptions;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProcessorErrorsHttp
{
    public static function throwAccessDenied(string $message)
    {
        throw new AccessDeniedHttpException(
            $message
        );
    }

    public static function throwNotFound(string $message)
    {
        throw new NotFoundHttpException(
            $message
        );
    }
}
