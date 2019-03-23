<?php

namespace App\Action\Phone;

use App\Domain\Phone\ShowPhone\NormalizerData;
use App\Domain\Phone\ShowPhone\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowPhone
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var NormalizerData  */
    protected $normalizerData;

    /**
     * ShowPhone constructor.
     * @param RequestResolver $requestResolver
     * @param NormalizerData $normalizerData
     */
    public function __construct(
        RequestResolver $requestResolver,
        NormalizerData $normalizerData
    ) {
        $this->requestResolver = $requestResolver;
        $this->normalizerData = $normalizerData;
    }

    /**
     * @Route("/api/phones/{phone_id}", name="show_phone", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(Request $request): Response
    {
        $input = $this->requestResolver->resolve($request);
        $data = $this->normalizerData->normalize($input);

        return JsonResponder::response(
            $data,
            Response::HTTP_OK,
            true
        );
    }
}
