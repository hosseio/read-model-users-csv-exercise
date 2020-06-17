<?php

namespace App\Tests\Application\User;

use App\Application\User\UserDTO;
use App\Domain\User\VO\ISO2Code;
use App\Tests\Tools\Stub\UserDTOStub;
use App\Tests\Tools\Stub\UserStub;
use Faker\Factory as FakerFactory;
use PHPUnit\Framework\TestCase;

class UserDTOTest extends TestCase
{
    public function testItCanBeCreatedFromArray()
    {
        $faker = FakerFactory::create('es_ES');

        $id = $faker->randomNumber();
        $name = $faker->name;
        $surname = $faker->name;
        $email = $faker->email;
        $country = ISO2Code::ES()->getValue();
        $createAt = $faker->dateTime;
        $activateAt = $faker->dateTime;
        $chargerID = $faker->randomNumber();

        $userDTO = UserDTO::fromArray([
            UserDTO::ID_KEY => $id,
            UserDTO::NAME_KEY => $name,
            UserDTO::SURNAME_KEY => $surname,
            UserDTO::EMAIL_KEY => $email,
            UserDTO::COUNTRY_KEY => $country,
            UserDTO::CREATE_AT_KEY => $createAt,
            UserDTO::ACTIVATE_AT_KEY => $activateAt,
            UserDTO::CHARGER_ID_KEY => $chargerID,
        ]);

        static::assertEquals($userDTO->id(), $id);
        static::assertEquals($userDTO->name(), $name);
        static::assertEquals($userDTO->surname(), $surname);
        static::assertEquals($userDTO->email(), $email);
        static::assertEquals($userDTO->iso2code(), $country);
        static::assertEquals($userDTO->creationDate(), $createAt);
        static::assertEquals($userDTO->activationDate(), $activateAt);
        static::assertEquals($userDTO->chargerCode(), $chargerID);
    }

    public function testItCanBeCreatedFromUser()
    {
        $user = UserStub::random();
        $userDTO = UserDTO::fromUser($user);

        static::assertEquals($user->userID()->value(), $userDTO->id());
        static::assertEquals($user->name()->value(), $userDTO->name());
        static::assertEquals($user->surname()->value(), $userDTO->surname());
        static::assertEquals($user->email()->value(), $userDTO->email());
        static::assertEquals($user->iso2code()->getValue(), $userDTO->iso2code());
        static::assertEquals($user->creationDate()->value(), $userDTO->creationDate());
        static::assertEquals($user->activationDate()->value(), $userDTO->activationDate());
        static::assertEquals($user->chargerCode()->value(), $userDTO->chargerCode());
    }

    public function testItIsSerializable()
    {
        $userDTO = UserDTOStub::random();
        $serialized = $userDTO->serialize();

        static::assertEquals($userDTO->id(), $serialized[UserDTO::ID_KEY]);
        static::assertEquals($userDTO->name(), $serialized[UserDTO::NAME_KEY]);
        static::assertEquals($userDTO->surname(), $serialized[UserDTO::SURNAME_KEY]);
        static::assertEquals($userDTO->email(), $serialized[UserDTO::EMAIL_KEY]);
        static::assertEquals($userDTO->iso2code(), $serialized[UserDTO::COUNTRY_KEY]);
        static::assertEquals($userDTO->creationDate()->format("Ymd"), $serialized[UserDTO::CREATE_AT_KEY]);
        static::assertEquals($userDTO->activationDate()->format("Ymd"), $serialized[UserDTO::ACTIVATE_AT_KEY]);
        static::assertEquals($userDTO->chargerCode(), $serialized[UserDTO::CHARGER_ID_KEY]);
    }

    public function testItCalculatesTheUserName()
    {
        $user = UserStub::create(['name' => "walter", 'surname' => "white"]);
        $userDTO = UserDTO::fromUser($user);

        static::assertEquals("walter white", $userDTO->userName());
    }
}
