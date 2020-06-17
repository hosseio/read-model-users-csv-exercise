<?php

namespace App\Test\Domain\User\VO;

use App\Domain\User\VO\Name;
use App\Domain\User\VO\UserID;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class UserIDTest extends TestCase
{
    public function testItCanBeCreated()
    {
        $faker = Factory::create();

        $number = $faker->randomNumber();
        $sut = UserID::create($number);
        static::assertEquals($number, $sut->value());
    }
}
