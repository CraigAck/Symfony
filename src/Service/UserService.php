<?php

namespace App\Service;

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
            $transformedUsers[] = [
                'id'    => $user->getId(),
                'name'  => $user->getName(),
            ];
        }

        return $transformedUsers;
    }
}