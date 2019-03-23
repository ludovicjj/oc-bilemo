<?php

namespace App\Domain\Common\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProcessorErrorsHttp
{
    public static function throwAccessDenied(string $message)
    {
        throw new HttpException(
            Response::HTTP_FORBIDDEN,
            $message
        );
    }

    public static function throwNotFound(string $message)
    {
        throw new HttpException(
            Response::HTTP_NOT_FOUND,
            $message
        );
    }
}
