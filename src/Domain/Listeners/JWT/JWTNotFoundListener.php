<?php

namespace App\Domain\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'code'  => 401,
            'message' => 'Le token est manquant.',
        ];

        $response = new JsonResponse($data, 401);

        $event->setResponse($response);
    }
}