<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{
    /**
     * @param string|null $data
     * @param int $statusCode
     * @param bool $cacheable
     * @param array $additionalHeaders
     * @return Response
     */
    public static function response(
        ?string $data,
        int $statusCode = Response::HTTP_OK,
        bool $cacheable = false,
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

        if ($cacheable) {
            $response
                ->setPublic()
                ->setSharedMaxAge(3600)
                ->setMaxAge(3600);
        }

        return $response;
    }
}
