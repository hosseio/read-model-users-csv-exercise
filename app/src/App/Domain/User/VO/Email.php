<?php

namespace App\Domain\User\VO;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Email
{
    /** @var string */
    private $value;

    private function  __construct(string $value)
    {
        try {
            Assertion::notBlank($value);
            Assertion::email($value);
        } catch (AssertionFailedException $e) {
            throw new InvalidEmailException($e->getMessage());
        }

        $this->value = $value;
    }

    /**
     * @param string $value
     * @return Email
     */
    public static function create(string $value): Email
    {
        return new self($value);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }

}
