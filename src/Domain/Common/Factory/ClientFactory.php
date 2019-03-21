<?php

namespace App\Domain\Common\Factory;

use App\Domain\Entity\Client;

class ClientFactory
{
    /**
     * @param string $username
     * @param string $password
     * @param string $email
     *
     * @return Client
     *
     * @throws \Exception
     */
    public static function create(
        string $username,
        string $password,
        string $email
    ) {
        $client = new Client();
        $client->createClient(
            $username,
            $password,
            $email
        );

        return $client;
    }
}