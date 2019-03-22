<?php

namespace App\Domain\Phone\ListPhone;

use App\Domain\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;

class Loader
{
    /** @var ListPhoneInput  */
    protected $listPhoneInput;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /**
     * Loader constructor.
     * @param ListPhoneInput $listPhoneInput
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ListPhoneInput $listPhoneInput,
        EntityManagerInterface $entityManager
    ) {
        $this->listPhoneInput = $listPhoneInput;
        $this->entityManager = $entityManager;
    }

    public function load(): ListPhoneInput
    {
        /** @var array $phones */
        $phones = $this->entityManager->getRepository(Phone::class)->findAll();
        $this->listPhoneInput->setPhone($phones);

        return $this->listPhoneInput->getInput();
    }
}