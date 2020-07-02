<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile\Self;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends BaseController
{
    private UserFetcher $users;

    /**
     * HomeController constructor.
     * @param UserFetcher $users
     */
    public function __construct(UserFetcher $users)
    {
        $this->users = $users;
    }

    /**
     * @Route("/profile", name="profile.self.home", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->users->getDetail($this->getUser()->getId());

        return $this->render('music/profile/self/home.html.twig', compact('user'));
    }
}