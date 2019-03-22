<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Maker
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 */
class Maker extends AbstractEntity
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"show_phone"})
     */
    protected $name;

    /**
     * @var ArrayCollection
     */
    protected $phones;

    /**
     * Maker constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->phones = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param string $name
     */
    public function createMaker(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
