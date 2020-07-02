<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Music\Song;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\Model\Music\Entity\Artist\ArtistRepository;
use App\Model\Music\UseCase\Song\Upload\Command;
use App\Model\Music\UseCase\Song\Upload\File;
use App\Model\Music\UseCase\Song\Upload\Form;
use App\Model\Music\UseCase\Song\Upload\Handler;
use App\Service\Uploader\SongUploader;
use DomainException;
use League\Flysystem\FileExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UploadController extends BaseController
{
    private ArtistRepository $artists;
    private ErrorHandler $errorHandler;

    /**
     * UploadController constructor.
     * @param ArtistRepository $artists
     * @param ErrorHandler $errorHandler
     */
    public function __construct(ArtistRepository $artists, ErrorHandler $errorHandler)
    {
        $this->artists = $artists;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @Route("/music/song/upload/{login}", name="music.song.upload", methods={"GET", "POST"})
     * @param Request $request
     * @param SongUploader $uploader
     * @param Handler $handler
     * @param string $login
     * @return Response
     * @throws FileExistsException
     */
    public function upload(Request $request, SongUploader $uploader, Handler $handler, string $login): Response
    {
        $artist = $this->artists->getByLogin($login);

        $command = new Command($artist);
        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $uploaded = $uploader->upload($form->get('file')->getData());
                $command->file = new File(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize(),
                );
                $handler->handle($command);
                $this->addFlash('success', 'Song successfully uploaded and sent for moderation.');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/song/upload.html.twig', [
            'form' => $form->createView()
        ]);
    }
}