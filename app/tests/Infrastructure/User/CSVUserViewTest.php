<?php

namespace App\Tests\Infrastructure\User;

use App\Infrastructure\User\CSVUserFilepathRetriever;
use App\Infrastructure\User\CSVUserView;
use PHPUnit\Framework\TestCase;

class CSVUserViewTest extends TestCase
{
    /** @var CSVUserViewTest */
    private $sut;

    /** @var CSVUserFilepathRetriever */
    private $csvUserFilepathRetriever;

    protected function setup(): void
    {
        $this->csvUserFilepathRetriever = $this->prophesize(CSVUserFilepathRetriever::class);
        $this->sut = new CSVUserView($this->csvUserFilepathRetriever->reveal());
    }

    public function testItParseTheFile()
    {
        $this->csvUserFilepathRetriever->get()->WillReturn(__DIR__."/users_test.csv");
        $userList = $this->sut->get();

        // check the users_test.csv file
        static::assertCount(5, $userList->users());

        $firstUser = $userList->users()->first();
        static::assertEquals(1, $firstUser->userID()->value());
        static::assertEquals("Lillian", $firstUser->name()->value());
        static::assertEquals("Harvey", $firstUser->surname()->value());
        static::assertEquals("lharvey0@oracle.com", $firstUser->email()->value());
        static::assertEquals("JO", $firstUser->iso2code()->getValue());
        static::assertEquals("2015-12-06", $firstUser->creationDate()->value()->format("Y-m-d"));
        static::assertEquals("2015-12-25", $firstUser->activationDAte()->value()->format("Y-m-d"));
        static::assertEquals(1, $firstUser->chargerCode()->value());

        $lastUser = $userList->users()->last();
        static::assertEquals(5, $lastUser->userID()->value());
        static::assertEquals("Emily", $lastUser->name()->value());
        static::assertEquals("Mills", $lastUser->surname()->value());
        static::assertEquals("emills4@flickr.com", $lastUser->email()->value());
        static::assertEquals("CN", $lastUser->iso2code()->getValue());
        static::assertEquals("2015-12-04", $lastUser->creationDate()->value()->format("Y-m-d"));
        static::assertEquals("2015-12-18", $lastUser->activationDAte()->value()->format("Y-m-d"));
        static::assertEquals(5, $lastUser->chargerCode()->value());
    }
}
