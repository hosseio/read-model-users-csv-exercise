<?php

namespace App\Tests\Tools\Stub;

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

class UserStub
{
    public static function random(): User
    {
        return self::create([]);
    }

    public static function create(array $params): User
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

        return User::hydrate(
            UserID::create($id),
            Name::create($name),
            Surname::create($surname),
            Email::create($email),
            ISO2Code::$country(),
            CreationDate::fromString($creationDate),
            ActivationDate::fromString($activationDate),
            ChargerCode::create($chargerCode)
        );
    }
}
