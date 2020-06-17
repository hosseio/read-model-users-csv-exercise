<?php

namespace App\Test\Domain\User\VO;

use App\Domain\User\VO\Surname;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class SurnameTest extends TestCase
{
    public function testItCanBeCreated()
    {
        $faker = Factory::create();

        $plainName = $faker->name;
        $sut = Surname::create($plainName);
        static::assertEquals($plainName, $sut->value());
    }
}
