<?php

declare(strict_types=1);

namespace App\Model\Music\Service;

class FileInfo
{
    public string $path;
    public string $format;
    public string $size;

    /**
     * FileInfo constructor.
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
}