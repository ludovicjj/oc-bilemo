<?php

namespace App\Action\Phone;

use App\Domain\Phone\ListPhone\Loader;
use App\Domain\Phone\ListPhone\NormalizerData;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListPhone
{
    /** @var Loader  */
    protected $loader;

    /** @var NormalizerData  */
    protected $normalizerData;

    /**
     * ListPhone constructor.
     * @param Loader $loader
     * @param NormalizerData $normalizerData
     */
    public function __construct(
        Loader $loader,
        NormalizerData $normalizerData
    ) {
        $this->loader = $loader;
        $this->normalizerData = $normalizerData;
    }

    /**
     * @Route("/api/phones", name="list_phone", methods={"GET"})
     * @return Response
     */
    public function listPhone()
    {
        $input = $this->loader->load();

        $data = $this->normalizerData->normalize($input);

        return JsonResponder::response(
            $data,
            is_null($data) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK,
            true
        );
    }
}
