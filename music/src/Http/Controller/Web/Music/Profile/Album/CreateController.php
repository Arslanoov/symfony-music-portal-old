<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Music\Profile\Album;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\Model\Music\Entity\Album\AlbumRepository;
use App\Model\Music\UseCase\Album\Create\Command;
use App\Model\Music\UseCase\Album\Create\File;
use App\Model\Music\UseCase\Album\Create\Form;
use App\Model\Music\UseCase\Album\Create\Handler;
use App\Service\Uploader\Music\AlbumCoverUploader;
use DomainException;
use League\Flysystem\FileExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends BaseController
{
    private AlbumRepository $albums;
    private ErrorHandler $errorHandler;

    /**
     * CreateController constructor.
     * @param AlbumRepository $albums
     * @param ErrorHandler $errorHandler
     */
    public function __construct(AlbumRepository $albums, ErrorHandler $errorHandler)
    {
        $this->albums = $albums;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @Route("/music/my/album/create", name="music.my.album.create")
     * @param Request $request
     * @param AlbumCoverUploader $uploader
     * @param Handler $handler
     * @return Response
     * @throws FileExistsException
     */
    public function request(Request $request, AlbumCoverUploader $uploader, Handler $handler): Response
    {
        $artistId = $this->getUser()->getId();

        $command = Command::byArtistId($artistId);
        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                if ($form->has('coverPhoto') and !empty($form->get('coverPhoto')->getData())) {
                    $uploaded = $uploader->upload($form->get('coverPhoto')->getData(), $command->title);
                    $command->coverPhoto = new File(
                        $uploaded->getPath(),
                        $uploaded->getName(),
                        $uploaded->getSize(),
                        $uploaded->getExt(),
                    );
                }

                $handler->handle($command);
                $this->addFlash('success', 'Album successfully created.');

                return $this->redirectToRoute('music.my');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/my/album/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}