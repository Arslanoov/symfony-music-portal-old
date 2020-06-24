<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile\Self;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\Model\User\UseCase\User\Avatar\Upload\Command;
use App\Model\User\UseCase\User\Avatar\Upload\File;
use App\Model\User\UseCase\User\Avatar\Upload\Form;
use App\Model\User\UseCase\User\Avatar\Upload\Handler;
use App\Service\Uploader\AvatarUploader;
use DomainException;
use League\Flysystem\FileExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvatarController extends BaseController
{
    private ErrorHandler $errorHandler;

    /**
     * AvatarController constructor.
     * @param ErrorHandler $errorHandler
     */
    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @Route("/profile/avatar/upload", name="profile.self.avatar.upload")
     * @param Request $request
     * @param AvatarUploader $uploader
     * @param Handler $handler
     * @return Response
     * @throws FileExistsException
     */
    public function upload(Request $request, AvatarUploader $uploader, Handler $handler): Response
    {
        $userId = $this->getUser()->getId();

        $command = Command::byId($userId);
        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $uploaded = $uploader->upload($form->get('avatar')->getData(), $userId);
                $command->file = new File(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize(),
                    $uploaded->getExt(),
                );
                $handler->handle($command);
                $this->addFlash('success', 'Avatar successfully uploaded.');
                return $this->redirectToRoute('profile.self.home');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/profile/self/avatar/upload.html.twig', [
            'form' => $form->createView()
        ]);
    }
}