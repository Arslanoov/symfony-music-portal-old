<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Music\Profile\Album;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Album\AlbumFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowController extends BaseController
{
    /**
     * @Route("/music/my/albums/{slug}", name="music.my.album.show", methods={"GET"})
     * @param AlbumFetcher $albumFetcher
     * @param string $slug
     * @return Response
     */
    public function show(AlbumFetcher $albumFetcher, string $slug): Response
    {
        $album = $albumFetcher->getDetailBySlug($slug);

        return $this->render('music/my/album/show.html.twig', [
            'album' => $album
        ]);
    }
}