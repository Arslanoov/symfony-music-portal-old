<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Album;

final class DetailView
{
    public string $id;
    public string $title;
    public string $slug;
    public string $created_date;
    public int $release_year;
    public ?string $cover_photo = null;
    public string $description;

    public int $listen_statistics_all;
    public int $listen_statistics_today;
    public int $listen_statistics_week;
    public int $listen_statistics_month;

    public int $download_statistics_all;
    public int $download_statistics_today;
    public int $download_statistics_week;
    public int $download_statistics_month;

    public string $status;
    public string $type;
    public int $songs_count;
}