<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\DTO;
use \DateTime;

class UserDTO implements DTO
{
    const ID_KEY = 'id';
    const NAME_KEY = 'name';
    const SURNAME_KEY = 'surname';
    const EMAIL_KEY = 'email';
    const COUNTRY_KEY = 'country';
    const CREATE_AT_KEY = 'createAt';
    const ACTIVATE_AT_KEY = 'activateAt';
    const CHARGER_ID_KEY = 'chargerId';

    /** @var int */
    private $userID;
    /** @var string */
    private $name;
    /** @var string */
    private $surname;
    /** @var string */
    private $email;
    /** @var string */
    private $iso2code;
    /** @var DateTime */
    private $creationDate;
    /** @var DateTime */
    private $activationDate;
    /** @var string */
    private $chargerCode;

    private function __construct(
        int $userID,
        string $name,
        string $surname,
        string $email,
        string $iso2code,
        DateTime $creationDate,
        DateTime $activationDate,
        string $chargerCode
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

    public function id(): int
    {
        return $this->userID;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function iso2code(): string
    {
        return $this->iso2code;
    }

    public function creationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function activationDate(): DateTime
    {
        return $this->activationDate;
    }

    public function chargerCode(): string
    {
        return $this->chargerCode;
    }

    public function serialize(): array
    {
        return [
            self::ID_KEY => $this->id(),
            self::NAME_KEY => $this->name(),
            self::SURNAME_KEY => $this->surname(),
            self::EMAIL_KEY => $this->email(),
            self::COUNTRY_KEY => $this->iso2code(),
            self::CREATE_AT_KEY => $this->creationDate()->format("Ymd"),
            self::ACTIVATE_AT_KEY => $this->activationDate()->format("Ymd"),
            self::CHARGER_ID_KEY => $this->chargerCode(),
        ];
    }

    public static function fromArray(array $data): DTO
    {
        return new self(
            $data[self::ID_KEY],
            $data[self::NAME_KEY],
            $data[self::SURNAME_KEY],
            $data[self::EMAIL_KEY],
            $data[self::COUNTRY_KEY],
            $data[self::CREATE_AT_KEY],
            $data[self::ACTIVATE_AT_KEY],
            $data[self::CHARGER_ID_KEY]
        );
    }

    public static function fromUser(User $user): UserDTO
    {
        return new self(
            $user->userID()->value(),
            $user->name()->value(),
            $user->surname()->value(),
            $user->email()->value(),
            $user->iso2code()->getValue(),
            $user->creationDate()->value(),
            $user->activationDate()->value(),
            $user->chargerCode()->value()
        );
    }

    public function userName(): string
    {
        return sprintf("%s %s", $this->name, $this->surname);
    }
}
