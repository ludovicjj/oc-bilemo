<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Common\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use App\Domain\Common\Factory\ClientFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Persister
{
    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * Persister constructor.
     * @param EncoderFactoryInterface $encoderFactory
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->encoderFactory = $encoderFactory;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param AddClientInput $input
     * @throws \Exception
     */
    public function persist(AddClientInput $input)
    {
        /** @var Client $client */
        $client = ClientFactory::create(
            $input->getUsername(),
            $this->encoderFactory->getEncoder(Client::class)->encodePassword($input->getPassword(), ''),
            $input->getEmail()
        );

        $constraintList = $this->validator->validate($client);
        ErrorsValidationFactory::buildError($constraintList);

        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
