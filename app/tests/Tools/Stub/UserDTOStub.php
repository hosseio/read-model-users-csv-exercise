<?php

namespace App\Tests\Tools\Stub;

use App\Application\User\UserDTO;

class UserDTOStub
{
    public static function random(): UserDTO
    {
        $user = UserStub::random();

        return UserDTO::fromUser($user);
    }
}
