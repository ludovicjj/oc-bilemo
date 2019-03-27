<?php

namespace App\Domain\Entity;

use JMS\Serializer\Annotation as JMS;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Class User
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion=@Hateoas\Exclusion(groups={"show_user"})
 * )
 * @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "list_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())" },
 *          absolute = true
 *      ),
 *     exclusion=@Hateoas\Exclusion(groups={"show_user"})
 * )
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion=@Hateoas\Exclusion(groups={"list_user"})
 * )
 * @Hateoas\Relation(
 *     "delete",
 *     href = @Hateoas\Route(
 *          "delete_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())", "user_id" = "expr(object.getId())" },
 *          absolute = true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"list_user"})
 * )
 * @Hateoas\Relation(
 *     "add",
 *     href = @Hateoas\Route(
 *          "add_user",
 *          parameters = { "client_id" = "expr(object.getClient().getId())" },
 *          absolute = true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"list_user"})
 * )
 *
 */
class User extends AbstractEntity
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_user", "show_user"})
     */
    protected $firstName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_user", "show_user"})
     */
    protected $lastName;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"show_user"})
     */
    protected $phoneNumber;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"show_user"})
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
