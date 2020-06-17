<?php

namespace App\Domain;

abstract class DomainEvent
{
    /**
     * @return string
     */
    abstract public function aggregateId(): string;
}
