<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Album\AlbumFetcher;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AlbumsController extends BaseController
{
    private AlbumFetcher $albums;
    private UserFetcher $users;

    /**
     * AlbumsController constructor.
     * @param AlbumFetcher $albums
     * @param UserFetcher $users
     */
    public function __construct(AlbumFetcher $albums, UserFetcher $users)
    {
        $this->albums = $albums;
        $this->users = $users;
    }

    /**
     * @Route("/artist/{login}/albums", name="profile.albums")
     * @param string $login
     * @return Response
     */
    public function index(string $login): Response
    {
        $user = $this->users->getDetailByLogin($login);
        $albums = $this->albums->findByArtist($user->id);

        $canEdit = false;
        if ($user->id === $this->getUser()->getId()) {
            $canEdit = true;
        }

        return $this->render('music/profile/albums.html.twig', [
            'canEdit' => $canEdit,
            'albums' => $albums,
            'user' => $user
        ]);
    }
}