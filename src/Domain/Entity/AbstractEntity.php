<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use JMS\Serializer\Annotation as JMS;

/**
 * Class AbstractEntity
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 */
abstract class AbstractEntity
{
    /**
     * @var string|UuidInterface
     * @JMS\Expose()
     * @JMS\Type("string")
     * @JMS\Groups({"list_user"})
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime|null
     */
    protected $updatedAt;

    /**
     * AbstractEntity constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
    }

    /**
     * @return UuidInterface|string
     */
    public function getId()
    {
        return is_object($this->id) ? $this->id->toString() : $this->id;
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
}
