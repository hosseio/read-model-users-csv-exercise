<?php

namespace App\Domain\User;

use App\Domain\AggregateRoot;
use App\Domain\User\Event\UserCreated;
use App\Domain\User\VO\ActivationDate;
use App\Domain\User\VO\ChargerCode;
use App\Domain\User\VO\CreationDate;
use App\Domain\User\VO\Email;
use App\Domain\User\VO\ISO2Code;
use App\Domain\User\VO\Surname;
use App\Domain\User\VO\Name;
use App\Domain\User\VO\UserID;

class User extends AggregateRoot
{
    /** @var UserID */
    private $userID;
    /** @var Name */
    private $name;
    /** @var Surname */
    private $surname;
    /** @var Email */
    private $email;
    /** @var ISO2Code */
    private $iso2code;
    /** @var CreationDate */
    private $creationDate;
    /** @var ActivationDate */
    private $activationDate;
    /** @var ChargerCode */
    private $chargerCode;

    private function __construct(
        UserID $userID,
        Name $name,
        Surname $surname,
        Email $email,
        ISO2Code $iso2code,
        CreationDate $creationDate,
        ActivationDate $activationDate,
        ChargerCode $chargerCode
    ) {
        $this->userID = $userID;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->iso2code = $iso2code;
        $this->creationDate = $creationDate;
        $this->activationDate = $activationDate;
        $this->chargerCode = $chargerCode;
    }

    public static function create(
        UserID $userID,
        Name $name,
        Surname $surname,
        Email $email,
        ISO2Code $iso2code,
        CreationDate $creationDate,
        ActivationDate $activationDate,
        ChargerCode $chargerCode
    ) {
        $user = new self(
            $userID,
            $name,
            $surname,
            $email,
            $iso2code,
            $creationDate,
            $activationDate,
            $chargerCode
        );

        $user->record(
            new UserCreated(
                $userID,
                $name,
                $surname,
                $email,
                $iso2code,
                $creationDate,
                $activationDate,
                $chargerCode
            )
        );

        return $user;
    }

    public static function hydrate(
        UserID $userID,
        Name $name,
        Surname $surname,
        Email $email,
        ISO2Code $iso2code,
        CreationDate $creationDate,
        ActivationDate $activationDate,
        ChargerCode $chargerCode
    ) {
        return new self(
            $userID,
            $name,
            $surname,
            $email,
            $iso2code,
            $creationDate,
            $activationDate,
            $chargerCode
        );
    }

    public function userID(): UserID
    {
        return $this->userID;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function surname(): Surname
    {
        return $this->surname;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function iso2code(): ISO2Code
    {
        return $this->iso2code;
    }

    public function creationDate(): CreationDate
    {
        return $this->creationDate;
    }

    public function activationDate(): ActivationDate
    {
        return $this->activationDate;
    }

    public function chargerCode(): ChargerCode
    {
        return $this->chargerCode;
    }
}
