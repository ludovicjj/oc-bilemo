<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{
    /**
     * @param string|null $data
     * @param int $statusCode
     * @param array $additionalHeaders
     * @return Response
     */
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
