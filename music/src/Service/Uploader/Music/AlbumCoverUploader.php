<?php

declare(strict_types=1);

namespace App\Service\Uploader\Music;

use App\Model\Music\Entity\Album\Album;
use App\Service\Uploader\File;
use League\Flysystem\FileExistsException;
use League\Flysystem\FilesystemInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AlbumCoverUploader
{
    private FilesystemInterface $storage;
    private string $baseUrl;

    /**
     * FileUploader constructor.
     * @param FilesystemInterface $storage
     * @param string $baseUrl
     */
    public function __construct(FilesystemInterface $storage, string $baseUrl)
    {
        $this->storage = $storage;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param UploadedFile $file
     * @param string $title
     * @return File
     * @throws FileExistsException
     */
    public function upload(UploadedFile $file, string $title): File
    {
        $path = '/music/albums/' . md5($title);
        $name = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();

        if (file_exists($path)) {
            $this->storage->deleteDir($path);
        }

        $this->storage->createDir($path);
        $stream = fopen($file->getRealPath(), 'rb+');
        $this->storage->writeStream($path . '/' . $name, $stream);
        fclose($stream);

        return new File($this->baseUrl . $path, $name, $file->getSize(), pathinfo($path, PATHINFO_EXTENSION));
    }
}