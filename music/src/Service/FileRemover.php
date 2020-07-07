<?php

declare(strict_types=1);

namespace App\Service\Remover;

use League\Flysystem\FilesystemInterface;

class FileRemover
{
    private FilesystemInterface $storage;

    /**
     * FileUploader constructor.
     * @param FilesystemInterface $storage
     */
    public function __construct(FilesystemInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $path
     * @param string $name
     * @return void
     */
    public function upload(string $path, string $name): void
    {
        $path = $path . md5($name);
        if (file_exists($path)) {
            $this->storage->deleteDir($path);
        }
    }
}