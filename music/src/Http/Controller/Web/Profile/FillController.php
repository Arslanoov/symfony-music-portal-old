<?php

declare(strict_types=1);

namespace App\Http\Controller\Web\Profile;

use App\Http\Controller\Web\BaseController;
use App\Model\Exception\ErrorHandler;
use App\ReadModel\User\UserFetcher;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Model\User\UseCase\User\Fill;
use Symfony\Component\Routing\Annotation\Route;

final class FillController extends BaseController
{
    private ErrorHandler $errorHandler;
    private UserFetcher $users;

    /**
     * FillController constructor.
     * @param ErrorHandler $errorHandler
     * @param UserFetcher $users
     */
    public function __construct(ErrorHandler $errorHandler, UserFetcher $users)
    {
        $this->errorHandler = $errorHandler;
        $this->users = $users;
    }

    /**
     * @Route("/profile/fill/login", name="profile.self.fill.login")
     * @param Request $request
     * @param Fill\Login\Handler $handler
     * @return Response
     */
    public function login(Request $request, Fill\Login\Handler $handler): Response
    {
        $user = $this->users->getDetail($this->getUser()->getId());

        $command = Fill\Login\Command::byId($user->id);

        $form = $this->createForm(Fill\Login\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('home');
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
            }
        }

        return $this->render('music/profile/fill/login.html.twig', [
            'form' => $form->createView(),
            'login' => $user->login
        ]);
    }

    /**
     * @Route("/profile/fill/about-me", name="profile.self.fill.about-me")
     * @param Request $request
     * @param Fill\AboutMe\Handler $handler
     * @return Response
     */
    public function aboutMe(Request $request, Fill\AboutMe\Handler $handler): Response
    {
        $user = $this->users->getDetail($this->getUser()->getId());

        $command = Fill\AboutMe\Command::fromId($user->id);

        $form = $this->createForm(Fill\AboutMe\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('profile.show', [
                    'login' => $user->login
                ]);
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
            }
        }

        return $this->render('music/profile/fill/about-me.html.twig', [
            'form' => $form->createView(),
            'aboutMe' => $user->info_about_me
        ]);
    }

    /**
     * @Route("/profile/fill/country", name="profile.self.fill.country")
     * @param Request $request
     * @param Fill\Country\Handler $handler
     * @return Response
     */
    public function country(Request $request, Fill\Country\Handler $handler): Response
    {
        $user = $this->users->getDetail($this->getUser()->getId());

        $command = Fill\Country\Command::byId($user->id);

        $form = $this->createForm(Fill\Country\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('profile.show', [
                    'login' => $user->login
                ]);
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
            }
        }

        return $this->render('music/profile/fill/country.html.twig', [
            'form' => $form->createView(),
            'country' => $user->info_country
        ]);
    }

    /**
     * @Route("/profile/fill/sex", name="profile.self.fill.sex")
     * @param Request $request
     * @param Fill\Sex\Handler $handler
     * @return Response
     */
    public function sex(Request $request, Fill\Sex\Handler $handler): Response
    {
        $user = $this->users->getDetail($this->getUser()->getId());

        $command = Fill\Sex\Command::byId($user->id);

        $form = $this->createForm(Fill\Sex\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('profile.show', [
                    'login' => $user->login
                ]);
            } catch (DomainException $e) {
                $this->errorHandler->handleWarning($e);
            }
        }

        return $this->render('music/profile/fill/sex.html.twig', [
            'form' => $form->createView(),
            'sex' => $user->info_sex
        ]);
    }
}