<?php

namespace App\Action\Client;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddClient
{
    /**
     * @Route("/api/clients", name="add_client", methods={"POST"})
     * @param Request $request
     */
    public function add(Request $request)
    {

    }
}