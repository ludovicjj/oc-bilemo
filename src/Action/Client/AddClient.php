<?php

namespace App\Action\Client;

use App\Domain\Client\AddClient\AddClientInput;
use App\Domain\Client\AddClient\Persister;
use App\Domain\Client\AddClient\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AddClient
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var Persister  */
    protected $persister;

    /**
     * AddClient constructor.
     * @param RequestResolver $requestResolver
     * @param Persister $persister
     */
    public function __construct(
        RequestResolver $requestResolver,
        Persister $persister
    ) {
        $this->requestResolver = $requestResolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/api/clients", name="add_client", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \App\Domain\Common\Exceptions\ValidatorException
     * @throws \Exception
     */
    public function add(Request $request)
    {
        /** @var AddClientInput $input */
        $input = $this->requestResolver->resolve($request);
        $this->persister->persist($input);

        return JsonResponder::response(
            null,
            Response::HTTP_CREATED
        );
    }
}
