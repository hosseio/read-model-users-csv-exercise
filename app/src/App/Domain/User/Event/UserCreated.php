<?php

namespace App\Domain\User\Event;

use App\Domain\DomainEvent;
use App\Domain\User\VO\ActivationDate;
use App\Domain\User\VO\ChargerCode;
use App\Domain\User\VO\CreationDate;
use App\Domain\User\VO\Email;
use App\Domain\User\VO\ISO2Code;
use App\Domain\User\VO\Surname;
use App\Domain\User\VO\Name;
use App\Domain\User\VO\UserID;

class UserCreated extends DomainEvent
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

    public function __construct(
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

    public function aggregateId(): string
    {
        return (string)$this->userID;
    }
}
