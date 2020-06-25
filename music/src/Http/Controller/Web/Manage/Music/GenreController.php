<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Manage\Music;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Genre\GenreFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GenreController
 * @package App\Http\Controller\Web\Manage\Music
 * @Route("/manage/genres", name="manage.genres")
 */
class GenreController extends BaseController
{
    /**
     * @Route("", name="", methods={"GET"})
     * @param GenreFetcher $genreFetcher
     * @return Response
     */
    public function index(GenreFetcher $genreFetcher): Response
    {
        $genres = $genreFetcher->all();

        return $this->render('manage/music/genre/home.html.twig', compact('genres'));
    }
}