<?php

namespace App\Domain;

abstract class AggregateRoot
{
    /** @var DomainEvent[]|array */
    private $events = [];

    final public function clean(): void
    {
        $this->events = [];
    }

    /**
     * @return DomainEvent[]|array
     */
    final public function getDomainEvents(): array
    {
        $domainEvents = $this->events;
        $this->events = [];

        return $domainEvents;
    }

    /**
     * @param DomainEvent $event
     */
    final protected function record(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
