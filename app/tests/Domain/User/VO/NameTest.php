<?php

namespace App\Test\Domain\User\VO;

use App\Domain\User\VO\Name;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testItCanBeCreated()
    {
        $faker = Factory::create();

        $plainName = $faker->name;
        $sut = Name::create($plainName);
        static::assertEquals($plainName, $sut->value());
    }
}
