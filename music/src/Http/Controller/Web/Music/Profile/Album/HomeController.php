<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Music\Profile\Album;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Album\AlbumFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends BaseController
{
    /**
     * @Route("/music/my/albums", name="music.my.album.home", methods={"GET"})
     * @param AlbumFetcher $albumFetcher
     * @return Response
     */
    public function index(AlbumFetcher $albumFetcher): Response
    {
        $artistId = $this->getUser()->getId();
        $albums = $albumFetcher->findByArtist($artistId);

        return $this->render('music/my/album/home.html.twig', [
            'albums' => $albums
        ]);
    }
}