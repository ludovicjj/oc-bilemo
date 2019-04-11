<?php

namespace App\Domain\Phone\ListPhone;

use App\Domain\Common\Factory\PaginationFactory;
use App\Domain\Entity\Phone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class Loader
{
    /** @var ListPhoneInput  */
    protected $listPhoneInput;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var PaginationFactory */
    protected $paginationFactory;

    /**
     * Loader constructor.
     * @param ListPhoneInput $listPhoneInput
     * @param EntityManagerInterface $entityManager
     * @param PaginationFactory $paginationFactory
     */
    public function __construct(
        ListPhoneInput $listPhoneInput,
        EntityManagerInterface $entityManager,
        PaginationFactory $paginationFactory
    ) {
        $this->listPhoneInput = $listPhoneInput;
        $this->entityManager = $entityManager;
        $this->paginationFactory = $paginationFactory;
    }

    /**
     * @param Request $request
     * @return ListPhoneInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function load(Request $request): ListPhoneInput
    {

        $phonePagination = $this->paginationFactory->createPagination(
            $this->entityManager->getRepository(Phone::class),
            $request
        );
        die;

        $this->listPhoneInput->setPhone($phoneCollectionPaginated);

        return $this->listPhoneInput->getInput();
    }
}
