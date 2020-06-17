<?php

namespace App\Infrastructure\Symfony\Controller;

use App\Application\User\UserQueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /** @var UserQueryService */
    private $userQueryService;

    public function __construct(UserQueryService $userQueryService)
    {
        $this->userQueryService = $userQueryService;
    }

    /**
     * @Route("/users", name="users")
     */
    public function index(Request $request)
    {
        $query = $request->query->all();
        $users = $this->userQueryService->get($query);

        return new JsonResponse(
            [
                'items' => $users->toArray(),
            ]
        );
    }
}
