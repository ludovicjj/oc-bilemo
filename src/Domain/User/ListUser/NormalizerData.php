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

    public function normalize(ListUserInput $input)
    {
        $data = $this->serializer->serialize(
            $input->getUsers(),
            'json',
            SerializationContext::create()->setGroups(['list_user'])
        );
        $result = json_decode($data, true);

        if (count($result) === 0) {
            return null;
        }

        return $data;
    }
}
