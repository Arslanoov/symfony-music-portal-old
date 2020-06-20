<?php

declare(strict_types=1);

namespace App\Http\Controller\Web;

use App\Model\User\UseCase\User\SignUp\ByEmail\Request\Handler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @return Response
     */
    public function index(Handler $handler): Response
    {
        return $this->render('music/home.html.twig');
    }
}