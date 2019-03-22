<?php

namespace App\Domain\Common\Factory;

use App\Domain\Entity\Maker;
use App\Domain\Entity\Phone;

class PhoneFactory
{
    /**
     * @param string $name
     * @param string $description
     * @param float $price
     * @param int $stock
     * @param Maker $maker
     * @return Phone
     * @throws \Exception
     */
    public static function create(
        string $name,
        string $description,
        float $price,
        int $stock,
        Maker $maker
    ) {
        $phone = new Phone();
        $phone->createPhone(
            $name,
            $description,
            $price,
            $stock,
            $maker
        );

        return $phone;
    }
}