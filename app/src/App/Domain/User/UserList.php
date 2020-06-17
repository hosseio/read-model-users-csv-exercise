<?php

namespace App\Domain\User;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use \IteratorAggregate;
use Traversable;

class UserList implements IteratorAggregate
{
    /** @var ArrayCollection|User[] */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function users(): ArrayCollection
    {
        return $this->users;
    }

    public function add(User $user)
    {
        $this->users->add($user);
    }

    public function getIterator()
    {
        return $this->users->getIterator();
    }
}
