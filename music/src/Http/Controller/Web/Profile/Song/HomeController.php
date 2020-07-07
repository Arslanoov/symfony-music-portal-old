<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile\Song;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Song\SongFetcher;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends BaseController
{
    /**
     * @Route("/artist/{login}/tracks", name="profile.tracks")
     * @param UserFetcher $userFetcher
     * @param SongFetcher $songFetcher
     * @param string $login
     * @return Response
     */
    public function index(UserFetcher $userFetcher, SongFetcher $songFetcher, string $login): Response
    {
        $user = $userFetcher->getDetailByLogin($login);
        $canEdit = false;
        if ($user->login === $this->getUser()->getLogin()) {
            $canEdit = true;
        }

        $tracks = $songFetcher->findByArtist($user->id, $canEdit, 20);

        return $this->render('music/profile/tracks.html.twig', [
            'user' => $user,
            'tracks' => $tracks,
            'canEdit' => $canEdit
        ]);
    }
}