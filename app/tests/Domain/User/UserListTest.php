<?php

namespace App\Tests\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserList;
use App\Domain\User\VO\ActivationDate;
use App\Domain\User\VO\ChargerCode;
use App\Domain\User\VO\CreationDate;
use App\Domain\User\VO\Email;
use App\Domain\User\VO\ISO2Code;
use App\Domain\User\VO\Name;
use App\Domain\User\VO\Surname;
use App\Domain\User\VO\UserID;
use App\Tests\Tools\Stub\UserStub;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class UserListTest extends TestCase
{
    public function testUsersCanBeAdded()
    {
        $sut = new UserList();

        $firstUser = UserStub::random();
        $sut->add($firstUser);

        $sut->add(UserStub::random());
        $sut->add(UserStub::random());
        $sut->add(UserStub::random());

        $lastUser = UserStub::random();
        $sut->add($lastUser);

        static::assertCount(5, $sut->users());
        static::assertEquals($firstUser, $sut->users()->first());
        static::assertEquals($lastUser, $sut->users()->last());
    }
}
