<?php

namespace App\Domain\User\ListUser;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Domain\Entity\Client;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;

class Loader
{
    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var Security */
    protected $security;

    /** @var ListUserInput */
    protected $listUserInput;

    /**
     * Loader constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param Security $security
     * @param ListUserInput $listUserInput
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        Security $security,
        ListUserInput $listUserInput
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->security = $security;
        $this->listUserInput = $listUserInput;
    }

    public function load(Request $request)
    {
        $clientId = $request->attributes->get('client_id');

        /** @var TokenInterface|null $token */
        $token = $this->tokenStorage->getToken();

        /** @var Client|string|null $client */
        $client = !\is_null($token) ? $token->getUser() : null;

        if (!$this->security->isGranted('CLIENT_CHECK', $clientId)) {
            throw new AccessDeniedHttpException('Vous n\'êtes pas autorisé à consulter ce catalogue d\'utilisateur');
        }

        /** @var PersistentCollection|null $users */
        $users = \is_object($client) ? $client->getUsers() : null;

        $this->listUserInput->setUser($users);

        return $this->listUserInput->getInput();
    }
}
