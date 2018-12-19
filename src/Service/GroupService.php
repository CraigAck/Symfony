<?php

namespace App\Service;

use App\Entity\Grp;

/**
 * @todo move repo logic into these services
 *
 * Class GroupService
 * @package App\Service
 */
class GroupService
{
    /**
     * @param array $groups
     * @return array
     */
    /**
     * @param array $groups
     * @return array
     */
    public function transform(array $groups): array
    {
        $stateId = NULL;
        $members = [];
        foreach ($groups as $group)
        {
            if (is_null($group['userId']))
            {
                $members[$group['id']] = [];
            } else {
                $members[$group['id']][] = [
                    'userId' => $group['userId'],
                    'userName' => $group['userName']
                ];
            }
        }

        $sorted = [];
        foreach ($groups as $group)
        {
            $sorted[$group['id']] = [
                'id'        => $group['id'],
                'name'      => $group['name'],
                'members'   => $members[$group['id']]
            ];
        }

        $trimmed = [];
        foreach ($sorted as $s)
        {
            $trimmed[] = $s;
        }

        return $trimmed;
    }
}