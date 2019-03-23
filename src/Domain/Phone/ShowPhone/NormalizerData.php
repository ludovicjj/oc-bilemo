<?php

namespace App\Domain\Phone\ShowPhone;

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

    public function normalize(ShowPhoneInput $input): string
    {
        $data = $this->serializer->serialize(
            $input->getPhone(),
            'json',
            SerializationContext::create()->setGroups(['show_phone'])
        );

        return $data;
    }
}
