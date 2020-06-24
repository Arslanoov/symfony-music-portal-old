<?php

declare(strict_types=1);

namespace App\Service\Remover;

use League\Flysystem\FilesystemInterface;

class AvatarRemover
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
     * @param string $userId
     * @return void
     */
    public function upload(string $userId): void
    {
        $path = 'avatar/' . $userId;
        if (file_exists($path)) {
            $this->storage->deleteDir($path);
        }
    }
}