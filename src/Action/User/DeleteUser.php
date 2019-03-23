<?php

namespace App\Action\User;

use App\Domain\User\DeleteUser\Deleter;
use App\Domain\User\DeleteUser\DeleteUserInput;
use App\Domain\User\DeleteUser\RequestResolver;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUser
{
    /** @var RequestResolver  */
    protected $requestResolver;

    /** @var Deleter  */
    protected $deleter;

    /**
     * DeleteUser constructor.
     * @param RequestResolver $requestResolver
     * @param Deleter $deleter
     */
    public function __construct(
        RequestResolver $requestResolver,
        Deleter $deleter
    ) {
        $this->requestResolver = $requestResolver;
        $this->deleter = $deleter;
    }

    /**
     * @Route("/api/clients/{client_id}/users/{user_id}", name="delete_user", methods={"DELETE"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function delete(Request $request)
    {
        /** @var DeleteUserInput $input */
        $input = $this->requestResolver->resolve($request);
        $this->deleter->delete($input);

        return JsonResponder::response(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}
