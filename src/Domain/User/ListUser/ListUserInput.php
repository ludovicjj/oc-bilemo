<?php

namespace App\Domain\User\ListUser;

use Doctrine\Common\Collections\Collection;

class ListUserInput
{
    /** @var Collection|null */
    protected $users;

    /**
     * @return Collection|null
     */
    public function getUsers(): ?Collection
    {
        return $this->users;
    }

    /**
     * @param Collection|null $users
     */
    public function setUser(?Collection $users): void
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
