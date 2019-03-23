<?php

namespace App\Domain\User\ListUser;

use Doctrine\ORM\PersistentCollection;

class ListUserInput
{
    /** @var PersistentCollection */
    protected $users;

    public function getUsers(): PersistentCollection
    {
        return $this->users;
    }

    public function setUser(PersistentCollection $users): void
    {
        $this->users = $users;
    }

    /**
     * @return ListUserInput
     */
    public function getInput(): ListUserInput
    {
        return $this;
    }
}
