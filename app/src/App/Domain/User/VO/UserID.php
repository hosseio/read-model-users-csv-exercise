<?php

namespace App\Domain\User\VO;

class UserID
{
    /** @var int */
    private $value;

    private function  __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param int $value
     * @return UserID
     */
    public static function create(int $value): UserID
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }
}
