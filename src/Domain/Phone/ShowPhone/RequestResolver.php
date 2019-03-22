<?php

namespace App\Domain\Phone\ShowPhone;

use App\Domain\Entity\Phone;
use App\Domain\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Common\Exceptions\ProcessorErrorsHttp;

class RequestResolver
{
    /** @var ShowPhoneInput  */
    protected $showPhoneInput;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    public function __construct(
        ShowPhoneInput $input,
        EntityManagerInterface $entityManager
    ) {
        $this->showPhoneInput = $input;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return ShowPhoneInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request): ShowPhoneInput
    {
        $phoneId = $request->attributes->get('phone_id');

        /** @var PhoneRepository $phoneRepository */
        $phoneRepository = $this->entityManager->getRepository(Phone::class);

        /** @var Phone|null $phone */
        $phone = $phoneRepository->phoneExist($phoneId);

        if (\is_null($phone)) {
            ProcessorErrorsHttp::throwNotFound(sprintf('Aucun téléphone ne correspond à l\'id : %s', $phoneId));
        }

        $this->showPhoneInput->setPhone($phone);

        return $this->showPhoneInput->getInput();
    }
}