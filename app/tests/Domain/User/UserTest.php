<?php

namespace App\Tests\Domain\User;

use App\Domain\User\Event\UserCreated;
use App\Domain\User\User;
use App\Domain\User\VO\ActivationDate;
use App\Domain\User\VO\ChargerCode;
use App\Domain\User\VO\CreationDate;
use App\Domain\User\VO\Email;
use App\Domain\User\VO\ISO2Code;
use App\Domain\User\VO\Name;
use App\Domain\User\VO\Surname;
use App\Domain\User\VO\UserID;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testItCanBeHydratedAndItsGettersWork()
    {
        $faker = Factory::create('es_ES');

        $id = $params['id'] ??$faker->randomNumber();
        $name = $params['name'] ??$faker->name;
        $surname = $params['surname'] ??$faker->name;
        $email = $params['email'] ??$faker->email;
        $country = $params['countryId'] ?? ISO2Code::ES()->getValue();
        $creationDate = $params['creationDate'] ?? $faker->dateTime->format(CreationDate::FORMAT);
        $activationDate = $params['activationDate'] ?? $faker->dateTime->format(ActivationDate::FORMAT);
        $chargerCode = $params['chargerCode'] ??$faker->randomNumber();

        $user = User::hydrate(
            UserID::create($id),
            Name::create($name),
            Surname::create($surname),
            Email::create($email),
            ISO2Code::$country(),
            CreationDate::fromString($creationDate),
            ActivationDate::fromString($activationDate),
            ChargerCode::create($chargerCode)
        );

        static::assertEquals($id, $user->userID()->value());
        static::assertEquals($name, $user->name()->value());
        static::assertEquals($surname, $user->surname()->value());
        static::assertEquals($email, $user->email()->value());
        static::assertEquals($country, $user->iso2code()->getValue());
        static::assertEquals($creationDate, $user->creationDate()->value()->format(CreationDate::FORMAT));
        static::assertEquals($activationDate, $user->activationDate()->value()->format(ActivationDate::FORMAT));
        static::assertEquals($chargerCode, $user->chargerCode()->value());
    }

    public function testWhenCreatedANewEventIsRecorded()
    {
        $faker = Factory::create('es_ES');

        $id = $params['id'] ??$faker->randomNumber();
        $name = $params['name'] ??$faker->name;
        $surname = $params['surname'] ??$faker->name;
        $email = $params['email'] ??$faker->email;
        $country = $params['countryId'] ?? ISO2Code::ES()->getValue();
        $creationDate = $params['creationDate'] ?? $faker->dateTime->format(CreationDate::FORMAT);
        $activationDate = $params['activationDate'] ?? $faker->dateTime->format(ActivationDate::FORMAT);
        $chargerCode = $params['chargerCode'] ??$faker->randomNumber();

        $user = User::create(
            UserID::create($id),
            Name::create($name),
            Surname::create($surname),
            Email::create($email),
            ISO2Code::$country(),
            CreationDate::fromString($creationDate),
            ActivationDate::fromString($activationDate),
            ChargerCode::create($chargerCode)
        );

        $domainEvents = $user->getDomainEvents();
        static::assertCount(1, $domainEvents);
        static::assertInstanceOf(UserCreated::class, $domainEvents[0]);
    }
}
