<?php

namespace App\Domain\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Client extends AbstractEntity implements UserInterface
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime|null
     */
    protected $updatedAt;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var ArrayCollection
     */
    protected $users;

    /**
     * Client constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->roles = ['ROLE_CLIENT'];
        parent::__construct();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function createClient(
        string $username,
        string $password,
        string $email
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return string|void|null
     */
    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
    }
}