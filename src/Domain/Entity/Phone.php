<?php

namespace App\Domain\Entity;

use JMS\Serializer\Annotation as JMS;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Class Phone
 * @package App\Domain\Entity
 * @JMS\ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_phone",
 *          parameters = { "phone_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"list_phone"})
 * )
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "show_phone",
 *          parameters = { "phone_id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"show_phone"})
 * )
 * @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "list_phone",
 *          absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups={"show_phone"})
 * )
 * @Hateoas\Relation(
 *     "maker",
 *     embedded = @Hateoas\Embedded("expr(object.getMaker())"),
 *     exclusion = @Hateoas\Exclusion(groups={"show_phone"})
 * )
 */
class Phone extends AbstractEntity
{
    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"list_phone", "show_phone"})
     */
    protected $name;

    /**
     * @var string
     * @JMS\Expose()
     * @JMS\Groups({"show_phone"})
     */
    protected $description;

    /**
     * @var float
     * @JMS\Expose()
     * @JMS\Groups({"list_phone", "show_phone"})
     */
    protected $price;

    /**
     * @var int
     * @JMS\Expose()
     * @JMS\Groups({"show_phone"})
     */
    protected $stock;

    /**
     * @var Maker
     */
    protected $maker;

    /**
     * Phone constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $name
     * @param string $description
     * @param float $price
     * @param int $stock
     * @param Maker $maker
     */
    public function createPhone(
        string $name,
        string $description,
        float $price,
        int $stock,
        Maker $maker
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->maker = $maker;
    }

    /***
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return Maker
     */
    public function getMaker(): Maker
    {
        return $this->maker;
    }
}
