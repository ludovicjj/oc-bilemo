<?php

namespace App\Action\User;

use Symfony\Component\Routing\Annotation\Route;

class ShowUser
{
    /**
     * @Route("/api/clients/{client_id}/users/{user_id}", name="show_user", methods={"GET"})
     */
    public function show()
    {

    }
}