<?php

namespace App\Domain\Phone\ListPhone;

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
     * @param ListPhoneInput $input
     * @return string|null
     */
    public function normalize(ListPhoneInput $input)
    {

        $context = new SerializationContext();
        $context->setGroups(['list_phone']);

        $data = $this->serializer->serialize(
            $input,
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
