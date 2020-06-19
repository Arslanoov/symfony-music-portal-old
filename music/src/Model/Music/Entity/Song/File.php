<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

class File
{
    private string $path;
    private string $format;
    private string $size;

    /**
     * File constructor.
     * @param string $path
     * @param string $format
     * @param string $size
     */
    public function __construct(string $path, string $format, string $size)
    {
        $this->path = $path;
        $this->format = $format;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }
}