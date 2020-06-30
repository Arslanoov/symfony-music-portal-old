<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Album\Create;

class File
{
    private string $path;
    private string $name;
    private string $format;
    private int $size;

    /**
     * File constructor.
     * @param string $path
     * @param string $name
     * @param string $format
     * @param int $size
     */
    public function __construct(string $path, string $name, int $size, string $format)
    {
        $this->path = $path;
        $this->name = $name;
        $this->format = $format;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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