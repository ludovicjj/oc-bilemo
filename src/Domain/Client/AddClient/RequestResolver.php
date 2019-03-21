<?php

namespace App\Domain\Client\AddClient;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class RequestResolver
{
    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(
        SerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
    }

    public function resolve(Request $request)
    {
        /** @var AddClientInput $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            AddClientInput::class,
            'json'
        );
    }
}