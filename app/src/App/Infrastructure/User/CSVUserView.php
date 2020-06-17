<?php

namespace App\Infrastructure\User;

use App\Domain\DomainException;
use App\Domain\User\User;
use App\Domain\User\UserList;
use App\Domain\User\UserView;
use App\Domain\User\VO\ActivationDate;
use App\Domain\User\VO\ChargerCode;
use App\Domain\User\VO\CreationDate;
use App\Domain\User\VO\Email;
use App\Domain\User\VO\ISO2Code;
use App\Domain\User\VO\Surname;
use App\Domain\User\VO\Name;
use App\Domain\User\VO\UserID;
use Symfony\Component\HttpKernel\KernelInterface;

class CSVUserView implements UserView
{
    const ID_POSITION = 0;
    const NAME_POSITION = 1;
    const SURNAME_POSITION = 2;
    const EMAIL_POSITION = 3;
    const COUNTRY_POSITION = 4;
    const CREATION_DATE_POSITION = 5;
    const ACTIVATION_DATE_POSITION = 6;
    const CHARGER_CODE_POSITION = 7;

    /** @var CSVUserFilepathRetriever */
    private $csvUserFilepathRetriever;

    public function __construct(CSVUserFilepathRetriever $csvUserFilepathRetriever)
    {
        $this->csvUserFilepathRetriever = $csvUserFilepathRetriever;
    }

    public function get(): UserList
    {
        $list = new UserList();

        $fileData = fopen($this->csvUserFilepathRetriever->get(), 'r');
        while (($line = fgetcsv($fileData)) !== false) {
            $id = $line[self::ID_POSITION];
            $name = $line[self::NAME_POSITION];
            $surname = $line[self::SURNAME_POSITION];
            $email = $line[self::EMAIL_POSITION];
            $country = $line[self::COUNTRY_POSITION];
            $creationDate = $line[self::CREATION_DATE_POSITION];
            $activationDate = $line[self::ACTIVATION_DATE_POSITION];
            $chargerCode = $line[self::CHARGER_CODE_POSITION];

            try {
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

                $list->add($user);
            } catch (DomainException $e){
                continue;
            }
        }

        return $list;
    }
}
