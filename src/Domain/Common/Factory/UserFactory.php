<?php

namespace App\Domain\Common\Factory;

use App\Domain\Entity\Client;
use App\Domain\Entity\User;

class UserFactory
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $phoneNumber
     * @param string $email
     * @param Client $client
     * @return User
     * @throws \Exception
     */
    public static function create(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        string $email,
        Client $client
    ) {
        $user = new User();
        $user->createUser(
            $firstName,
            $lastName,
            $phoneNumber,
            $email,
            $client
        );

        return $user;
    }
}
