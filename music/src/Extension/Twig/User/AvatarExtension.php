<?php

declare(strict_types=1);

namespace App\Extension\Twig\User;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AvatarExtension extends AbstractExtension
{
    private const STORAGE_URL = 'localhost:8081';

    public function getFunctions(): array
    {
        return [
            new TwigFunction('avatar', [$this, 'avatar'], ['is_safe' => ['html']]),
        ];
    }

    public function avatar(string $path): string
    {
        return '//' . self::STORAGE_URL . '/' . $path;
    }
}