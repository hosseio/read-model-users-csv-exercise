<?php

namespace App\Domain\User\VO;

class ChargerCode
{
    /** @var int */
    private $value;

    private function  __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param int $value
     * @return ChargerCode
     */
    public static function create(int $value): ChargerCode
    {
        return new self($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value();
    }

}
