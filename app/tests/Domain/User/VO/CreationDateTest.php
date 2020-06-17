<?php

namespace App\Test\Domain\User\VO;

use App\Domain\User\VO\CreationDate;
use PHPUnit\Framework\TestCase;

class CreationDateTest extends TestCase
{
    public function testItCanBeCreatedAndItsValueCanBeRetrieved()
    {
        $sut = CreationDate::fromString("2014-05-23");

        static::assertInstanceOf(CreationDate::class, $sut);
        static::assertEquals("2014-05-23", $sut->value()->format(CreationDate::FORMAT));
    }
}
