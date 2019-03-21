<?php

namespace App\Domain\Client\AddClient;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver
{
    /** @var SerializerInterface */
    protected $serializer;

    protected $validator;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function resolve(Request $request)
    {
        /** @var AddClientInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddClientInput::class,
            'json'
        );

        $constraintList = $this->validator->validate($input);
    }
}