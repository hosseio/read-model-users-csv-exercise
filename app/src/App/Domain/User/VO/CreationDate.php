<?php

namespace App\Domain\User\VO;

use \DateTime;

class CreationDate
{
    const FORMAT = "Y-m-d";

    /** @var DateTime */
    private $value;

    private function  __construct(DateTime $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return CreationDate
     */
    public static function fromString(string $value): CreationDate
    {
        $date = DateTime::createFromFormat(self::FORMAT, $value);

        return new self($date);
    }

    public function value(): DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format(self::FORMAT);
    }
}
