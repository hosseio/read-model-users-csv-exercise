<?php

namespace App\Test\Domain\User\VO;

use App\Domain\User\VO\Email;
use App\Domain\User\VO\InvalidEmailException;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testGivenAValidEmailItCanBeCreated()
    {
        $faker = Factory::create();

        $plainEmail = $faker->email;
        $email = Email::create($plainEmail);
        static::assertEquals($plainEmail, $email->value());
    }

    public function testGivenAnInvalidEmailItIsNotCreated()
    {
        $faker = Factory::create();

        $wrongEmail = $faker->name;
        static::expectException(InvalidEmailException::class);
        Email::create($wrongEmail);
    }
}
