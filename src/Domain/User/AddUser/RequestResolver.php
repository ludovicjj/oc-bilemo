<?php

namespace App\Domain\User\AddUser;

use App\Domain\Common\Exceptions\ProcessorErrorsHttp;
use App\Domain\Common\Factory\ErrorsValidationFactory;
use App\Domain\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Security;

class RequestResolver
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var Security  */
    protected $security;

    /**
     * RequestResolver constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param Security $security
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        Security $security
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return AddUserInput
     * @throws \App\Domain\Common\Exceptions\ValidatorException
     */
    public function resolve(Request $request): AddUserInput
    {
        /** @var Client $client */
        $client = $this->tokenStorage->getToken()->getUser();
        $clientId = $request->attributes->get('client_id');

        if (!$this->security->isGranted('CLIENT_CHECK', $clientId)) {
            ProcessorErrorsHttp::throwAccessDenied(
                'Vous n\'êtes pas autorisé à ajouter un utilisateur dans ce catalogue.'
            );
        }

        /** @var AddUserInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddUserInput::class,
            'json'
        );

        $input->setClient($client);

        $constraintList = $this->validator->validate($input);
        ErrorsValidationFactory::buildError($constraintList);

        return $input;
    }
}
