<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Album;

final class ProfileView
{
    public string $id;
    public string $title;
    public string $slug;
    public string $created_date;
    public int $release_year;
    public ?string $cover_photo = null;

    public int $listen_statistics_all;
    public int $download_statistics_all;

    public string $status;
    public string $type;
}