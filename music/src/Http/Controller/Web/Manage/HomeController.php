<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Manage;

use App\Http\Controller\Web\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("manage", name="manage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('manage/home.html.twig');
    }
}