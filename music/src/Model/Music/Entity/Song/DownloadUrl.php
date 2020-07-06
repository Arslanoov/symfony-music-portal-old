<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use Webmozart\Assert\Assert;

final class DownloadUrl
{
    private string $value;

    /**
     * Url constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public function getRaw(): string
    {
        return $this->value;
    }

    public function getHttps(): string
    {
        return 'https://' . $this->value;
    }

    public function getHttp(): string
    {
        return 'http://' . $this->value;
    }

    public function isEqual(DownloadUrl $url): bool
    {
        return $this->value === $url->getRaw();
    }
}