<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Music\Profile;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Album\AlbumFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends BaseController
{
    private AlbumFetcher $albums;

    /**
     * HomeController constructor.
     * @param AlbumFetcher $albums
     */
    public function __construct(AlbumFetcher $albums)
    {
        $this->albums = $albums;
    }

    /**
     * @Route("/music/my", name="music.my", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $artistId = $this->getUser()->getId();

        $myAlbums = $this->albums->findByArtistLimit($artistId);
        $mySongs = [];

        return $this->render('music/my/home.html.twig', [
            'albums'  =>$myAlbums,
            'songs' => $mySongs
        ]);
    }
}