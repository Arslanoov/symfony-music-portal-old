<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\Single;

class File
{
    private string $path;
    private string $format;
    private int $size;

    public function __construct(string $path, string $format, int $size)
    {
        $this->path = $path;
        $this->format = $format;
        $this->size = $size;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}