<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Login;
use RuntimeException;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ConfirmEmailTokenSender implements TokenSender
{
    private Swift_Mailer $mailer;
    private Environment $twig;

    public function __construct(Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param Login $login
     * @param Email $email
     * @param ConfirmToken $token
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function send(Login $login, Email $email, ConfirmToken $token): void
    {
        $message = (new Swift_Message('Sign Up Confirmation'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/signup.html.twig', [
                'login' => $login->getValue(),
                'token' => $token->getValue()
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new RuntimeException('Unable to send message.');
        }
    }
}