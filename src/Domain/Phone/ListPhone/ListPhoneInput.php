<?php

namespace App\Domain\Phone\ListPhone;

class ListPhoneInput
{
    /** @var array */
    protected $phone;

    public function setPhone(array $phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone(): array
    {
        return $this->phone;
    }

    public function getInput(): ListPhoneInput
    {
        return $this;
    }
}
