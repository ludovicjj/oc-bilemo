<?php

namespace App\Domain\User\DeleteUser;

use App\Domain\Entity\User;

class DeleteUserInput
{
    /** @var User */
    protected $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return DeleteUserInput
     */
    public function getInput(): DeleteUserInput
    {
        return $this;
    }
}
