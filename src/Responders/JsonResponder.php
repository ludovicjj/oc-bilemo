<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{
    public static function response(
        ?string $data,
        int $statusCode = Response::HTTP_OK,
        array $additionalHeaders = []
    ) {
        $response = new Response(
            $data,
            $statusCode,
            array_merge(
                [
                    'content-type' => 'application/json',
                    'X-API-Version' => getenv('API_VERSION'),
                ],
                $additionalHeaders
            )
        );

        return $response;
    }
}
