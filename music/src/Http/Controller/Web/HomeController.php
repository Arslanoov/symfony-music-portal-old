<?php

declare(strict_types=1);

namespace App\Http\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends BaseController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('music/home.html.twig');
    }
}