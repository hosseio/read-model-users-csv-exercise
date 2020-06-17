<?php

namespace App;

interface DTO
{
    public function serialize(): array;
    public static function fromArray(array $data): self;
}
