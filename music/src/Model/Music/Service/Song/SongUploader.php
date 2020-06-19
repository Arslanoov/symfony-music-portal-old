<?php

declare(strict_types=1);

namespace App\Model\Music\Service\Song;

use App\Model\Music\Service\FileInfo;
use App\Model\Music\Service\Uploader;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webmozart\Assert\Assert;

class SongUploader implements Uploader
{
    private string $path;

    /**
     * SongUploader constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function upload(UploadedFile $file): FileInfo
    {
        $ext = pathinfo($file->getPath(), PATHINFO_EXTENSION) ?: 'mp3';

        $filename = $this->generateFileName($file, $ext);
        $path = $this->path . '/' . $filename;

        $file->move($path);

        return new FileInfo(
            $path, $ext, ($file->getSize() / 1024 / 1024) . 'mb'
        );
    }

    private function generateFileName(UploadedFile $file, string $ext): string
    {
        $name = Uuid::uuid4()->toString();
        return $name . '.' . $ext;
    }
}