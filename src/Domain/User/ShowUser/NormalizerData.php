<?php

namespace App\Domain\User\ShowUser;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class NormalizerData
{
    /** @var SerializerInterface  */
    protected $serializer;

    /**
     * NormalizerData constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @param ShowUserInput $input
     * @return string
     */
    public function normalize(ShowUserInput $input): string
    {
        $context = new SerializationContext();
        $context->setGroups(['show_user']);

        $data = $this->serializer->serialize(
            $input->getUser(),
            'json',
            $context
        );

        return $data;
    }
}
