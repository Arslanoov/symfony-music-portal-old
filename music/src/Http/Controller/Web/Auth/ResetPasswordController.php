<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Auth;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\ReadModel\User\UserFetcher;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\User\UseCase\User\ResetPassword;

final class ResetPasswordController extends BaseController
{
    private ErrorHandler $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/auth/reset-password/request", name="auth.reset-password.request")
     * @param Request $request
     * @param ResetPassword\Request\Handler $handler
     * @return Response
     */
    public function request(Request $request, ResetPassword\Request\Handler $handler): Response
    {
        $command = new ResetPassword\Request\Command();

        $form = $this->createForm(ResetPassword\Request\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Check your email.');
                return $this->redirectToRoute('home');
            } catch (DomainException $e) {
                $this->errors->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/auth/reset-password/request.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/auth/reset-password/confirm/{token}", name="auth.reset-password.confirm")
     * @param string $token
     * @param Request $request
     * @param ResetPassword\Confirm\Handler $handler
     * @param UserFetcher $users
     * @return Response
     */
    public function reset(string $token, Request $request, ResetPassword\Confirm\Handler $handler, UserFetcher $users): Response
    {
        if (!$users->existsByPasswordResetToken($token)) {
            $this->addFlash('error', 'Incorrect or already confirmed token.');
            return $this->redirectToRoute('home');
        }

        $command = ResetPassword\Confirm\Command::byToken($token);

        $form = $this->createForm(ResetPassword\Confirm\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Password is successfully changed.');
                return $this->redirectToRoute('auth.login');
            } catch (DomainException $e) {
                $this->errors->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/auth/reset-password/confirm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}