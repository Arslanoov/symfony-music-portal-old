<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Auth;

use App\Http\Controller\Web\BaseController;
use App\Model\ErrorHandler;
use App\Model\User\Entity\User\ConfirmToken;
use App\ReadModel\User\UserFetcher;
use App\Security\LoginFormAuthenticator;
use DomainException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Model\User\UseCase\User\SignUp\ByEmail;

class SignUpController extends BaseController
{
    private UserFetcher $users;
    private ErrorHandler $errorHandler;

    /**
     * SignUpController constructor.
     * @param UserFetcher $users
     * @param ErrorHandler $errorHandler
     */
    public function __construct(UserFetcher $users, ErrorHandler $errorHandler)
    {
        $this->users = $users;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @Route("/signup", name="auth.signup")
     * @param Request $request
     * @param ByEmail\Request\Handler $handler
     * @param UserProviderInterface $userProvider
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     * @throws Exception
     */
    public function request(
        Request $request,
        ByEmail\Request\Handler $handler,
        UserProviderInterface $userProvider,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator
    ): Response
    {
        $command = new ByEmail\Request\Command();

        $form = $this->createForm(ByEmail\Request\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Check your email.');
                return $this->redirectToRoute('home');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('music/auth/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/signup/{token}", name="auth.signup.confirm")
     * @param Request $request
     * @param string $token
     * @param ByEmail\Confirm\ByToken\Handler $handler
     * @param UserProviderInterface $userProvider
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     */
    public function confirm(
        Request $request,
        string $token,
        ByEmail\Confirm\ByToken\Handler $handler,
        UserProviderInterface $userProvider,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator
    ): Response
    {
        $confirmToken = new ConfirmToken($token);

        if (!$user = $this->users->findBySignUpConfirmToken($confirmToken->getValue())) {
            $this->addFlash('error', 'Incorrect or already confirmed token.');
            return $this->redirectToRoute('auth.signup');
        }

        $command = new ByEmail\Confirm\ByToken\Command($confirmToken->getValue());

        try {
            $handler->handle($command);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $userProvider->loadUserByUsername($user->login),
                $request,
                $authenticator,
                'main'
            );
        } catch (DomainException $e) {
            $this->errorHandler->handleWarning($e);
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('home');
        }
    }
}