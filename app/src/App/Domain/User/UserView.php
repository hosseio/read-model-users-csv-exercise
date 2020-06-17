<?php

namespace App\Domain\User;

interface UserView
{
    public function get(): UserList;
}
