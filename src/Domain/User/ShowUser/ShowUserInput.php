<?php

namespace App\Domain\User\ShowUser;

use App\Domain\Entity\User;

class ShowUserInput
{
    /** @var User */
    protected $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return ShowUserInput
     */
    public function getInput(): ShowUserInput
    {
        return $this;
    }
}
