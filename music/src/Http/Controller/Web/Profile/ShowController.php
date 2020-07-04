<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile;

use App\Http\Controller\Web\BaseController;
use App\Model\Music\Entity\Album\Album;
use App\Model\User\UseCase\User\IncreaseProfileViews\Command;
use App\Model\User\UseCase\User\IncreaseProfileViews\Handler;
use App\ReadModel\Music\Album\AlbumFetcher;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowController extends BaseController
{
    /**
     * @Route("/artist/{login}", name="profile.show", methods={"GET"})
     * @param UserFetcher $users
     * @param AlbumFetcher $albums
     * @param Handler $handler
     * @param string $login
     * @return Response
     */
    public function view(UserFetcher $users, AlbumFetcher $albums, Handler $handler, string $login): Response
    {
        $currentUser = $this->getUser();
        $user = $users->getDetailByLogin($login);

        $canEdit = false;
        if ($currentUser and $this->getUser()->getId() === $user->id) {
            $canEdit = true;
        }

        if (!$canEdit) {
            $handler->handle(new Command($user->id));
        }

        $bestAlbums = $albums->findMostPopularArtistAlbums($user->id, 2);
        $recentAlbums = $albums->findRecentArtistAlbums($user->id);

        return $this->render('music/profile/show.html.twig', [
            'user' => $user,
            'bestAlbums' => $bestAlbums,
            'recentAlbums' => $recentAlbums,
            'canEdit' => $canEdit
        ]);
    }
}