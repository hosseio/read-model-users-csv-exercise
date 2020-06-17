<?php

namespace App\Tests\Application\User;

use App\Application\User\UserDTO;
use App\Application\User\UserDTOList;
use App\Domain\User\UserList;
use App\Tests\Tools\Stub\UserDTOStub;
use App\Tests\Tools\Stub\UserStub;
use PHPUnit\Framework\TestCase;

class UserDTOListTest extends TestCase
{
    /** @var UserDTOList */
    private $sut;

    public function testItCanAddUserDTOs()
    {
        $sut = new UserDTOList();
        static::assertCount(0, $sut->users());

        $sut->add(UserDTOStub::random());
        static::assertCount(1, $sut->users());

        $sut->add(UserDTOStub::random());
        static::assertCount(2, $sut->users());
    }

    public function testItCanBeCreatedFromUserList()
    {
        $list = new UserList();

        $firstUser = UserStub::random();
        $list->add($firstUser);
        $secondUser = UserStub::random();
        $list->add($secondUser);

        $userDTOList = UserDTOList::fromUsers($list);

        static::assertCount(2, $userDTOList->users());
        static::assertEquals($firstUser->email()->value(), $userDTOList->users()->first()->email());
        static::assertEquals($secondUser->email()->value(), $userDTOList->users()->last()->email());
    }

    public function testItCanBeTransformToArray()
    {
        $list = new UserList();

        $firstUser = UserStub::random();
        $list->add($firstUser);
        $secondUser = UserStub::random();
        $list->add($secondUser);

        $userDTOList = UserDTOList::fromUsers($list);

        $toArray = $userDTOList->toArray();
        static::assertIsArray($toArray);
        static::assertCount(2, $toArray);
    }

    public function testItCanBeOrderedByUserName()
    {
        $sut = new UserDTOList();

        $zUserDTO = UserDTO::fromUser(UserStub::create(['name' => 'zeta']));
        $sut->add($zUserDTO);

        $aUserDTO = UserDTO::fromUser(UserStub::create(['name' => 'anakin']));
        $sut->add($aUserDTO);

        $hUserDTO = UserDTO::fromUser(UserStub::create(['name' => 'hobbes']));
        $sut->add($hUserDTO);

        $wUserDTO = UserDTO::fromUser(UserStub::create(['name' => 'walter']));
        $sut->add($wUserDTO);

        static::assertEquals($zUserDTO->id(), $sut->users()->first()->id());
        static::assertEquals($wUserDTO->id(), $sut->users()->last()->id());
        $sut->order();
        static::assertEquals($aUserDTO->id(), $sut->users()->first()->id());
        static::assertEquals($zUserDTO->id(), $sut->users()->last()->id());
    }

    public function testItFiltersByActivationLength()
    {
        $sut = $this->userDTOListFilterProvider();
        $sut->filter([UserDTOList::ACTIVATION_LENGTH => 5]);
        static::assertCount(2, $sut->users());
    }

    public function testItFiltersByCountries()
    {
        $sut = $this->userDTOListFilterProvider();
        $sut->filter([UserDTOList::COUNTRIES => ['ES', 'GB']]);
        static::assertCount(4, $sut->users());
    }

    public function testItFiltersByCountriesAndActivationLength()
    {
        $sut = $this->userDTOListFilterProvider();
        $sut->filter([UserDTOList::ACTIVATION_LENGTH => 5, UserDTOList::COUNTRIES => ['ES', 'GB']]);
        static::assertCount(2, $sut->users());
    }

    private function userDTOListFilterProvider(): UserDTOList
    {
        $list = new UserDTOList();

        $list->add(
            UserDTO::fromUser(
                UserStub::create([
                    'creationDate' => '2020-01-01',
                    'activationDate' => '2020-01-05',
                    'countryId' => 'ES'
                ]) // 4 days activation_length
            )
        );
        $list->add(
            UserDTO::fromUser(
                UserStub::create([
                    'creationDate' => '2020-02-01',
                    'activationDate' => '2020-02-02',
                    'countryId' => 'GB'
                ]) // 1 day activation_length
            )
        );
        $list->add(
            UserDTO::fromUser(
                UserStub::create([
                    'creationDate' => '2020-02-01',
                    'activationDate' => '2020-02-15',
                    'countryId' => 'ES'
                ]) // 14 days activation_length
            )
        );
        $list->add(
            UserDTO::fromUser(
                UserStub::create([
                    'creationDate' => '2020-05-01',
                    'activationDate' => '2020-05-03',
                    'countryId' => 'IT'
                ]) // 2 day activation_length
            )
        );
        $list->add(
            UserDTO::fromUser(
                UserStub::create([
                    'creationDate' => '2020-05-01',
                    'activationDate' => '2020-05-07',
                    'countryId' => 'ES'
                ]) // 6 days activation_length
            )
        );

        return $list;
    }
}
