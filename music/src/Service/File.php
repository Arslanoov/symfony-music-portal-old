<?php

declare(strict_types=1);

namespace App\Service\Uploader;

class File
{
    private string $path;
    private string $name;
    private int $size;
    private string $ext;

    /**
     * File constructor.
     * @param string $path
     * @param string $name
     * @param int $size
     * @param string $ext
     */
    public function __construct(string $path, string $name, int $size, string $ext)
    {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
        $this->ext = $ext;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getExt(): string
    {
        return $this->ext;
    }
}