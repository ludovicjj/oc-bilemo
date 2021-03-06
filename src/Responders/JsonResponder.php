<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{
    /**
     * @param Request $request
     * @param string|null $data
     * @param int $statusCode
     * @param bool $cacheAble
     * @param array $additionalHeaders
     * @return Response
     */
    public static function response(
        Request $request,
        ?string $data,
        int $statusCode = Response::HTTP_OK,
        bool $cacheAble = false,
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

        if ($cacheAble) {
            $response
                ->setEtag(md5($response->getContent()))
                ->setPublic()
                ->isNotModified($request)
            ;
        }

        return $response;
    }
}
