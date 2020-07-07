<?php

declare(strict_types=1);

namespace App\Service;

use App\Service\Uploader\File;
use Exception;
use League\Flysystem\FileExistsException;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileUploader
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
     * @param string $folderPath
     * @param string $folderName
     * @return File
     * @throws FileExistsException
     * @throws Exception
     */
    public function upload(UploadedFile $file, string $folderPath, string $folderName): File
    {
        $path = $folderPath . md5($folderName);
        $name = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();

        $this->storage->createDir($path);
        $stream = fopen($file->getRealPath(), 'rb+');
        $this->storage->writeStream($path . '/' . $name, $stream);
        fclose($stream);

        return new File($this->baseUrl . '/' . $path, $name, $file->getSize(), $file->getClientOriginalExtension());
    }
}