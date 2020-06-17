<?php

namespace App\Test\Domain\User\VO;

use App\Domain\User\VO\ActivationDate;
use PHPUnit\Framework\TestCase;

class ActivationDateTest extends TestCase
{
    public function testItCanBeCreatedAndItsValueCanBeRetrieved()
    {
        $sut = ActivationDate::fromString("2018-05-05");

        static::assertInstanceOf(ActivationDate::class, $sut);
        static::assertEquals("2018-05-05", $sut->value()->format(ActivationDate::FORMAT));
    }
}
