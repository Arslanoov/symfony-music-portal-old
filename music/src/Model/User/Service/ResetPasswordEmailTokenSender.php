<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\ResetPasswordToken;
use DomainException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Swift_Mailer;
use Swift_Message;
use RuntimeException;

class ResetPasswordEmailTokenSender implements TokenSender
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
    public function send(Login $login, Email $email, $token): void
    {
        if (!$token instanceof ResetPasswordToken) {
            throw new DomainException('Incorrect token.');
        }

        $message = (new Swift_Message('Reset Password'))
            ->setTo($email->getValue())
            ->setBody($this->twig->render('mail/user/reset-password.html.twig', [
                'login' => $login->getValue(),
                'token' => $token->getToken()
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new RuntimeException('Unable to send message.');
        }
    }
}