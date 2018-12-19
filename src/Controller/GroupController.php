<?php

namespace App\Controller;

use App\Entity\Grp;
use App\Entity\GrpsUsers;
use App\Entity\User;
use App\Repository\GrpRepository;
use App\Service\GroupService;
use FOS\RestBundle\Controller\Annotations AS Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GroupController
 * @package App\Controller
 */
class GroupController extends FOSRestController
{
    /**
     * Get list of all groups
     *
     * @Rest\Get("/groups")
     * @return JsonResponse
     */
    public function getAll(GroupService $groupService): JsonResponse
    {
        $groups = $this->getDoctrine()
            ->getRepository(Grp::class)
            ->findAllWithMembers();

        return $this->json(['items' => $groupService->transform($groups)], Response::HTTP_OK);
    }

    /**
     * Create a group
     *
     * @Rest\Post("/groups")
     * @param Request $request
     * @return JsonResponse
     */
    public function post(Request $request, GroupService $groupService): JsonResponse
    {
        $groups = $this->getDoctrine()
            ->getRepository(Grp::class)
            ->create($request->get('name'));

        return $this->json(["message" => "Group added successfully", "item" => $groupService->transform($groups)], Response::HTTP_OK);
    }

    /**
     * Delete a group
     *
     * @Rest\Delete("/groups")
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        if ($this->getDoctrine()
            ->getRepository(Grp::class)
            ->deleteGroup($request->get('id')))
        {
            return $this->json(["message" => "Group deleted successfully"], Response::HTTP_OK);
        }

        return $this->json(["message" => "Group not deleted - it is not empty"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Add a user to a group
     *
     * @Rest\Post("/groups/{id}/user")
     * @param Request $request
     * @return JsonResponse
     */
    public function addUser(int $id, Request $request, GroupService $groupService): JsonResponse
    {
        if ($groups = $this->getDoctrine()
            ->getRepository(Grp::class)
            ->addUser($id, $request->get('userId')))
        {
            return $this->json(["message" => "User added to group", "items" => $groupService->transform($groups)], Response::HTTP_OK);
        }

        return $this->json(["message" => "User already a member of that group"], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Add a user to a group
     *
     * @Rest\Delete("/groups/{id}/user")
     * @param Request $request
     * @return JsonResponse
     */
    public function removeUser(int $id, Request $request): JsonResponse
    {
        if ($this->getDoctrine()
            ->getRepository(Grp::class)
            ->deleteUser($id, $request->get('userId')))
        {
            return $this->json(["message" => "User removed from group successfully"], Response::HTTP_OK);
        }

        return $this->json(["message" => "User is not part of that group"], Response::HTTP_BAD_REQUEST);
    }


}
