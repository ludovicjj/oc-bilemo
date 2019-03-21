<?php

namespace App\Action\Client;

use App\Domain\Client\AddClient\RequestResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddClient
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /**
     * AddClient constructor.
     * @param RequestResolver $requestResolver
     */
    public function __construct(
        RequestResolver $requestResolver
    )
    {
        $this->requestResolver = $requestResolver;
    }

    /**
     * @Route("/api/clients", name="add_client", methods={"POST"})
     * @param Request $request
     */
    public function add(Request $request)
    {
        $this->requestResolver->resolve($request);
    }
}