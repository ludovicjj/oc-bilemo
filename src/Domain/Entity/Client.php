<?php

namespace App\Domain\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Client
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 */
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
     * @var array
     */
    protected $roles;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var ArrayCollection
     * @JMS\Expose()
     * @JMS\Groups({"list_user"})
     */
    protected $users;

    /**
     * Client constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
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
