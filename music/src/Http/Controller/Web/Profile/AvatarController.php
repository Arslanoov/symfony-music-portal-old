<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\Model\User\UseCase\User\Avatar;
use App\Model\User\UseCase\User\Avatar\Upload\File;
use App\Model\User\UseCase\User\Avatar\Upload\Form;
use App\ReadModel\User\UserFetcher;
use App\Service\Remover\AvatarRemover;
use App\Service\Uploader\AvatarUploader;
use DomainException;
use League\Flysystem\FileExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AvatarController extends BaseController
{
    private ErrorHandler $errorHandler;
    private UserFetcher $users;

    /**
     * AvatarController constructor.
     * @param ErrorHandler $errorHandler
     * @param UserFetcher $users
     */
    public function __construct(ErrorHandler $errorHandler, UserFetcher $users)
    {
        $this->errorHandler = $errorHandler;
        $this->users = $users;
    }

    /**
     * @Route("/profile/avatar/upload", name="profile.self.avatar.upload")
     * @param Request $request
     * @param AvatarUploader $uploader
     * @param Avatar\Upload\Handler $handler
     * @return Response
     * @throws FileExistsException
     */
    public function upload(Request $request, AvatarUploader $uploader, Avatar\Upload\Handler $handler): Response
    {
        $user = $this->users->getDetail($this->getUser()->getId());

        $command = Avatar\Upload\Command::byId($user->id);
        $form = $this->createForm(Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $uploaded = $uploader->upload($form->get('avatar')->getData(), $user->id);
                $command->file = new File(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize(),
                    $uploaded->getExt(),
                );
                $handler->handle($command);
                $this->addFlash('success', 'Avatar successfully uploaded.');
                return $this->redirectToRoute('profile.show', [
                    'login' => $user->login
                ]);
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/profile/avatar/upload.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/avatar/remove", name="profile.self.avatar.remove", methods={"POST"})
     * @param Request $request
     * @param AvatarRemover $uploader
     * @param Avatar\Remove\Handler $handler
     * @return Response
     */
    public function remove(Request $request, AvatarRemover $uploader, Avatar\Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('remove-avatar', $request->request->get('token'))) {
            return $this->redirectToRoute('profile.show');
        }

        $user = $this->users->getDetail($this->getUser()->getId());

        $command = new Avatar\Remove\Command($user->id);

        try {
            $handler->handle($command);
            $this->addFlash('success', 'Avatar successfully removed.');
        } catch (DomainException $e) {
            $this->errorHandler->handleWarning($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('profile.show', [
            'login' => $user->login
        ]);
    }
}