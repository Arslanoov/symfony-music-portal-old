<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile\Song;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\Model\Music\Entity\Artist\ArtistRepository;
use App\Model\Music\Entity\Artist\Login;
use App\ReadModel\Music\Album\AlbumFetcher;
use App\Service\FileUploader;
use DomainException;
use Exception;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Music\UseCase\Song\Upload;

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
     * @Route("/artist/{login}/song/upload/single", name="profile.song.upload.single", methods={"GET", "POST"})
     * @param Request $request
     * @param FileUploader $uploader
     * @param Upload\Single\Handler $handler
     * @param string $login
     * @return Response
     * @throws Exception
     */
    public function single(
        Request $request, FileUploader $uploader,
        Upload\Single\Handler $handler, string $login
    ): Response
    {
        $this->checkCanEdit($login);

        $artist = $this->artists->getByLogin(new Login($login));

        $command = Upload\Single\Command::byArtist($artist->getLogin()->getValue());
        $form = $this->createForm(Upload\Single\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $uploadedSong = $uploader->upload($form->get('file')->getData(), 'music/songs/', $command->name);
                $command->file = new Upload\Single\File($uploadedSong->getPath(), $uploadedSong->getExt(), $uploadedSong->getSize());
                $uploadedCover = $uploader->upload($form->get('coverPhoto')->getData(), 'music/singles/cover/', $command->name);
                $command->coverPhoto = new Upload\Single\Photo($uploadedCover->getPath(), $uploadedCover->getName(), $uploadedCover->getSize(), $uploadedCover->getExt());

                $handler->handle($command);
                $this->addFlash('success', 'Song successfully uploaded and sent for moderation.');

                return $this->redirectToRoute('profile.tracks', [
                    'login' => $login
                ]);
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/profile/song/upload/single.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/artist/{login}/album/{slug}/song/upload", name="profile.song.upload.for-album", methods={"GET", "POST"})
     * @param Request $request
     * @param FileUploader $uploader
     * @param AlbumFetcher $albums
     * @param Upload\ForAlbum\Handler $handler
     * @param string $login
     * @param string $slug
     * @return Response
     * @throws FileExistsException
     * @throws FileNotFoundException
     */
    public function album(
        Request $request, FileUploader $uploader,
        AlbumFetcher $albums, Upload\ForAlbum\Handler $handler,
        string $login, string $slug
    ): Response
    {
        $this->checkCanEdit($login);

        $album = $albums->getShortBySlug($slug);

        $command = new Upload\ForAlbum\Command($login, $album->slug);
        $form = $this->createForm(Upload\ForAlbum\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $uploaded = $uploader->upload($form->get('file')->getData(), 'music/albums/' . md5($album->id) . '/songs/', $command->id);
                $command->file = new Upload\ForAlbum\File(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize()
                );
                $handler->handle($command);
                $this->addFlash('success', 'Song successfully uploaded and sent for moderation.');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/song/upload/single.html.twig', [
            'form' => $form->createView(),
            'album' => $album
        ]);
    }

    private function checkCanEdit(string $login): void
    {
        if ($login !== $this->getUser()->getLogin()) {
            throw new AccessDeniedHttpException();
        }
    }
}