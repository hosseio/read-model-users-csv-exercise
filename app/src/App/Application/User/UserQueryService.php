<?php

namespace App\Application\User;

use App\Domain\User\UserView;

class UserQueryService
{
    /** @var UserView */
    private $userView;

    public function __construct(UserView $userView)
    {
        $this->userView = $userView;
    }

    /**
     * @param array $criteria
     * @return UserDTOList
     */
    public function get(array $criteria): UserDTOList
    {
        $users = $this->userView->get();

        $userDTOList = UserDTOList::fromUsers($users);
        if (!empty($criteria)) {
            $userDTOList->filter($criteria);
        }
        $userDTOList->order();

        return $userDTOList;
    }
}
