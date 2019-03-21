<?php

namespace App\Domain\Client\AddClient;

use App\Domain\Common\Factory\ErrorsValidationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /**
     * RequestResolver constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @return AddClientInput
     * @throws \App\Domain\Common\Exceptions\ValidatorException
     */
    public function resolve(Request $request): AddClientInput
    {
        /** @var AddClientInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddClientInput::class,
            'json'
        );

        $constraintList = $this->validator->validate($input);
        ErrorsValidationFactory::buildError($constraintList);

        return $input;
    }
}
