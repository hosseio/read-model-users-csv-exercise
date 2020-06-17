<?php

namespace App\Domain\User\VO;

class Name
{
    /** @var string */
    private $value;

    private function  __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return Name
     */
    public static function create(string $value): Name
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
