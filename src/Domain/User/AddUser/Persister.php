<?php

namespace App\Domain\User\AddUser;

use App\Domain\Common\Factory\ErrorsValidationFactory;
use App\Domain\Common\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Persister
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var ValidatorInterface  */
    protected $validator;

    /** @var UrlGeneratorInterface  */
    protected $urlGenerator;

    /**
     * Persister constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param AddUserInput $input
     * @return array
     * @throws \App\Domain\Common\Exceptions\ValidatorException
     * @throws \Exception
     */
    public function persist(AddUserInput $input)
    {
        $user = UserFactory::create(
            $input->getFirstName(),
            $input->getLastName(),
            $input->getPhoneNumber(),
            $input->getEmail(),
            $input->getClient()
        );

        $constraintList = $this->validator->validate($user);
        ErrorsValidationFactory::buildError($constraintList);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return [
            'Location' => $this->urlGenerator->generate(
                'show_user',
                ['client_id' => $user->getClient()->getId(), 'user_id' => $user->getId()]
            )
        ];
    }
}
