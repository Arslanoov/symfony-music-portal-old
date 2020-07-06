<?php

declare(strict_types=1);

namespace App\Extension\Twig\Music\Song;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class StatusExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('music_song_status', [$this, 'status'], ['needs_environment' => true, 'is_safe' => ['html']])
        ];
    }

    /**
     * @param Environment $twig
     * @param string $status
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function status(Environment $twig, string $status): string
    {
        return $twig->render('extension/music/song/status.html.twig', [
            'status' => $status
        ]);
    }
}