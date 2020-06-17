<?php

namespace App\Application\User;

use App\Domain\User\UserList;
use Doctrine\Common\Collections\ArrayCollection;
use \IteratorAggregate;

class UserDTOList implements IteratorAggregate
{
    const ACTIVATION_LENGTH = 'activation_length';
    const COUNTRIES = 'countries';

    /** @var ArrayCollection|UserDTO[] */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @param UserDTO $user
     */
    public function add(UserDTO $user)
    {
        $this->users->add($user);
    }

    /**
     * @return ArrayCollection|UserDTO[]
     */
    public function users(): ArrayCollection
    {
        return $this->users;
    }

    public static function fromUsers(UserList $users): UserDTOList
    {
        $list = new self();
        foreach($users as $user) {
            $list->users->add(UserDTO::fromUser($user));
        }

        return $list;
    }

    public function order()
    {
        $iterator = $this->users->getIterator();
        $iterator->uasort(function (UserDTO $a, UserDTO $b) {
            return ($a->userName() < $b->userName()) ? -1 : 1;
        });

        $this->users = new ArrayCollection(iterator_to_array($iterator));
    }

    public function toArray(): array
    {
        if (!$this->users || $this->users->isEmpty()) {
            return [];
        }

        $result = [];
        foreach ($this->users as $user) {
            $result[] = $user->serialize();
        }

        return $result;
    }

    public function filter(array $criteria)
    {
        $activationLength = $criteria[self::ACTIVATION_LENGTH] ?? null;
        $countries = $criteria[self::COUNTRIES] ?? null;

        $this->users = $this->users->filter(
            function(UserDTO $user) use ($activationLength, $countries) {
                return
                    $this->activationLengthFilter($user, $activationLength) &&
                    $this->countriesFilter($user, $countries);
            }
        );
    }

    public function getIterator()
    {
        return $this->users->getIterator();
    }

    private function activationLengthFilter(UserDTO $user, ?int $activationLength): bool
    {
        if (!$activationLength) {
            return true;
        }

        $creationDate = $user->creationDate();
        $activationDate = $user->activationDate();

        $diff = $activationDate->diff($creationDate);

        return $diff->days >= $activationLength;
    }

    private function countriesFilter(UserDTO $user, ?array $countries): bool
    {
        if (!$countries || empty($countries)) {
            return true;
        }

        foreach ($countries as $country) {
            if ($user->iso2code() == strtoupper($country)) {
                return true;
            }
        }

        return false;
    }
}
