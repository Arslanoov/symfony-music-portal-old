<?php

declare(strict_types=1);

namespace App\Extension\Twig\User;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RoleExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('user_role', [$this, 'role'], ['needs_environment' => true, 'is_safe' => ['html']])
        ];
    }

    /**
     * @param Environment $twig
     * @param string $role
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function role(Environment $twig, string $role): string
    {
        return $twig->render('extension/user/role.html.twig', [
            'role' => $role
        ]);
    }
}