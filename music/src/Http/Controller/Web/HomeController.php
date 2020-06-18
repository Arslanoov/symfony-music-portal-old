<?php

declare(strict_types=1);

namespace App\Controller\Web;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
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