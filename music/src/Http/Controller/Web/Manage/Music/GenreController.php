<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Manage\Music;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\ReadModel\Music\Genre\GenreFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Music\UseCase\Genre;
use DomainException;
use App\Model\Music\Entity\Genre\Genre as GenreEntity;

/**
 * final class GenreController
 * @package App\Http\Controller\Web\Manage\Music
 * @Route("/manage/genres", name="manage.genres")
 * @IsGranted("ROLE_MANAGE_GENRES")
 */
final class GenreController extends BaseController
{
    private ErrorHandler $errorHandler;

    /**
     * GenreController constructor.
     * @param ErrorHandler $errorHandler
     */
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

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

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Genre\Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Genre\Create\Handler $handler): Response
    {
        $command = new Genre\Create\Command();

        $form = $this->createForm(Genre\Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Genre successfully created');
                return $this->redirectToRoute('manage.genres');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
            }
        }

        return $this->render('manage/music/genre/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name=".edit")
     * @param Request $request
     * @param GenreEntity $genre
     * @param Genre\Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Genre\Edit\Handler $handler, GenreEntity $genre): Response
    {
        $command = Genre\Edit\Command::byId($genre->getId()->getValue());

        $form = $this->createForm(Genre\Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Genre successfully edited.');
                return $this->redirectToRoute('manage.genres');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
            }
        }

        return $this->render('manage/music/genre/edit.html.twig', [
            'form' => $form->createView(),
            'genreName' => $genre->getName()->getValue()
        ]);
    }

    /**
     * @Route("/remove/{id}", name=".remove", methods={"POST"})
     * @param Request $request
     * @param GenreEntity $genre
     * @param Genre\Remove\Handler $handler
     * @return Response
     */
    public function remove(Request $request, Genre\Remove\Handler $handler, GenreEntity $genre): Response
    {
        if (!$this->isCsrfTokenValid('manage-genre-delete', $request->request->get('token'))) {
            return $this->redirectToRoute('manage.genres');
        }

        $command = new Genre\Remove\Command($genre->getId()->getValue());

        try {
            $handler->handle($command);
            $this->addFlash('success', 'Genre successfully removed.');
            return $this->redirectToRoute('manage.genres');
        } catch (DomainException $e) {
            $this->errorHandler->handleWarning($e);
        }

        return $this->redirectToRoute('manage.genres');
    }
}