<?php

namespace App\Domain\Entity;

class User extends AbstractEntity
{
    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var Client
     */
    protected $client;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $phoneNumber
     * @param string $email
     * @param Client $client
     */
    public function createUser(
        string $firstName,
        string $lastName,
        string $phoneNumber,
        string $email,
        Client $client
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
