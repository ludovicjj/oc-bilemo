<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;

class ErrorResponder
{
    public static function response(
        ?string $data,
        int $statusCode = Response::HTTP_OK
    ) {
        $response = new Response(
            $data,
            $statusCode,
            [
                'content-type' => 'application/json',
            ]
        );
        return $response;
    }
}
