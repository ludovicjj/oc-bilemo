<?php

namespace App\Domain\User\ListUser;

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
     * @param ListUserInput $input
     * @return string|null
     */
    public function normalize(ListUserInput $input)
    {
        $context = new SerializationContext();
        $context->setGroups(['list_user']);

        $data = $this->serializer->serialize(
            $input->getUsers(),
            'json',
            $context
        );

        $result = json_decode($data, true);

        if (count($result) === 0) {
            return null;
        }

        return $data;
    }
}
