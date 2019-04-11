<?php

namespace App\Domain\Phone\ListPhone;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

class ListPhoneInput
{
    /**
     * @var int
     * @Serializer\Groups({"list_phone"})
     */
    protected $totalItems;

    /**
     * @var int
     * @Serializer\Groups({"list_phone"})
     */
    protected $currentPage;

    /**
     * @var array
     * @Serializer\Groups({"list_phone"})
     */
    protected $links;

    /**
     * @var array
     * @Type("array<App\Domain\Entity\Phone>")
     * @Serializer\Groups({"list_phone"})
     */
    protected $phone;

    public function setPhone(array $phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone(): array
    {
        return $this->phone;
    }

    public function setLinks(array $links)
    {
        $this->links = $links;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
    }

    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }


    public function getInput(): ListPhoneInput
    {
        return $this;
    }
}
