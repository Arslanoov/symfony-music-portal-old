<?php

declare(strict_types=1);

namespace App\Model\Music\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface Uploader
{
    public function upload(UploadedFile $file): FileInfo;
}