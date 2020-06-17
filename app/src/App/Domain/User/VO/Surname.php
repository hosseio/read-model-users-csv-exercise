<?php

namespace App\Domain\User\VO;

class Surname
{
    /** @var string */
    private $value;

    private function  __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return Surname
     */
    public static function create(string $value): Surname
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }
}
