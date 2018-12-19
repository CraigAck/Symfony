<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use FOS\RestBundle\Controller\Annotations AS Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends FOSRestController
{
    /**
     * Get list of all users
     *
     * @Rest\Get("/users")
     * @return JsonResponse
     */
    public function getAll(UserService $userService): JsonResponse
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->json(['items' => $userService->transform($users)], Response::HTTP_OK);
    }

    /**
     * Get single user by id
     *
     * @Rest\Get("/user/{id}")
     * @return JsonResponse
     */
    public function getOne(int $id, UserService $userService): JsonResponse
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        return $this->json(['items' => $userService->transformSingle($users)], Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/users")
     * @param Request $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function post(Request $request, UserService $userService): JsonResponse
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->create($request->get('name'));

        return $this->json(["message" => "User added successfully", "item" => $userService->transform([$user])], Response::HTTP_CREATED);
    }

    /**
     * Delete a user
     *
     * @Rest\Delete("/users")
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $this->getDoctrine()
            ->getRepository(User::class)
            ->deleteUser($request->get('id'));

        return $this->json(["message" => ""], Response::HTTP_NO_CONTENT);
    }
}
