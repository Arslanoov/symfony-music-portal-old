<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Manage\Music;

use App\Http\Controller\Web\BaseController;
use App\ReadModel\Music\Genre\GenreFetcher;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Music\UseCase\Genre;

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

    public function create(Request $request, Genre\Create\Handler $handler): Response
    {
        $command = new Genre\Create\Command();

        $form = $this->createForm(Genre\Create\Form::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Genre successfully created');
                return $this->redirectToRoute('manage.genres');
            } catch (DomainException $e) {
                
            }
        }
    }
}