<?php

namespace App\Domain\User\DeleteUser;

use Doctrine\ORM\EntityManagerInterface;

class Deleter
{
    /** @var EntityManagerInterface  */
    protected $entityManager;

    /**
     * Deleter constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeleteUserInput $input
     */
    public function delete(DeleteUserInput $input): void
    {
        $this->entityManager->remove($input->getUser());
        $this->entityManager->flush();
    }
}
