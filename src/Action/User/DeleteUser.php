<?php

namespace App\Action\User;

use Symfony\Component\Routing\Annotation\Route;

class DeleteUser
{
    /**
     * @Route("/api/clients/{client_id}/users/{user_id}", name="delete_user", methods={"DELETE"})
     */
    public function delete()
    {

    }
}