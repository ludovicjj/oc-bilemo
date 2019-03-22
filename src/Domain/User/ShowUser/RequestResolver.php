<?php

namespace App\Domain\User\ShowUser;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use App\Domain\Common\Exceptions\ProcessorErrorsHttp;

class RequestResolver
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var ShowUserInput  */
    protected $showUserInput;

    /** @var Security  */
    protected $security;

    /**
     * RequestResolver constructor.
     * @param EntityManagerInterface $entityManager
     * @param ShowUserInput $showUserInput
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ShowUserInput $showUserInput,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->showUserInput = $showUserInput;
        $this->security = $security;
    }

    /**
     * @param Request $request
     * @return ShowUserInput
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function resolve(Request $request): ShowUserInput
    {
        $clientId = $request->attributes->get('client_id');
        $userId = $request->attributes->get('user_id');

        if (!$this->security->isGranted('CLIENT_CHECK', $clientId)) {
            ProcessorErrorsHttp::throwAccessDenied(
                'Vous n\'êtes pas autorisé à consulter les informations de cet utilisateur.'
            );
        }

        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);

        /** @var User|null $user */
        $user = $userRepository->userExist($userId);

        if (\is_null($user)) {
            ProcessorErrorsHttp::throwNotFound(sprintf('Aucun utilisateur ne correspond à l\'id : %s', $userId));
        }

        $this->showUserInput->setUser($user);

        return $this->showUserInput->getInput();
    }
}