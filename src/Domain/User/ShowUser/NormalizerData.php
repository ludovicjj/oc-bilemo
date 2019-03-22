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
        $data = $this->serializer->serialize(
            $input->getUser(),
            'json',
            SerializationContext::create()->setGroups(['show_user'])
        );

        return $data;
    }
}