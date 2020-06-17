<?php

namespace App\Tests\Application\User;

use App\Application\User\UserQueryService;
use App\Domain\User\UserList;
use App\Domain\User\UserView;
use App\Tests\Tools\Stub\UserStub;
use PHPUnit\Framework\TestCase;

class UserQueryServiceTest extends TestCase
{
    /** @var UserQueryService */
    private $sut;
    /** @var UserView */
    private $userView;

    protected function setup(): void
    {
        $this->userView = $this->prophesize(UserView::class);

        $this->sut = New UserQueryService($this->userView->reveal());
    }

    public function testItDelegatesOnUserViewAndReturnsAnOrderedList()
    {
        $userList = new UserList();

        $aUser = UserStub::create(['name' => 'anakin']);
        $userList->add($aUser);
        $wUser = UserStub::create(['name' => 'walter']);
        $userList->add($wUser);
        $bUser = UserStub::create(['name' => 'barbara']);
        $userList->add($bUser);

        $criteria = [];

        $this->userView->get()->shouldBeCalled()->willReturn($userList);

        $result = $this->sut->get($criteria);
        static::assertEquals($aUser->userID()->value(), $result->users()->first()->id());
        static::assertEquals($wUser->userID()->value(), $result->users()->last()->id());
    }
}
