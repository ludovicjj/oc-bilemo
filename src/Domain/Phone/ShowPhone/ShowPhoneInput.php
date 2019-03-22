<?php

namespace App\Domain\Phone\ShowPhone;

use App\Domain\Entity\Phone;

class ShowPhoneInput
{
    /** @var Phone */
    protected $phone;

    public function setPhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getInput(): ShowPhoneInput
    {
        return $this;
    }
}