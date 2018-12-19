<?php

namespace App\Service;

use App\Entity\User;

class UserService
{
    /**
     * @param array $users
     * @return array
     */
    public function transform(array $users): array
    {
        $transformedUsers = [];
        foreach ($users as $user)
        {
            $transformedUsers[] = $this->transformSingle($user);
        }

        return $transformedUsers;
    }

    /**
     * @param User $user
     * @return array
     */
    public function transformSingle(User $user): array
    {
        return  [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
        ];
    }
}