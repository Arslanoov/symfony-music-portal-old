<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends BaseController
{
    /**
     * @Route("/api", name="api.home", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse([
            'version' => '1.0'
        ]);
    }
}
