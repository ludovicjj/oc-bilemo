<?php

namespace App\Domain\Listeners\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;

class AuthenticationFailureListener
{
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $data = 'Mauvais identifiants. Vérifier votre nom d\'utilisateur/mot de passe.';

        $response = new JWTAuthenticationFailureResponse($data);

        $event->setResponse($response);
    }
}