<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class File
 * @package App\Model\Music\Entity\Song
 * @ORM\Embeddable()
 */
class File
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $path;
    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private string $format;
    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private string $size;

    /**
     * File constructor.
     * @param string $path
     * @param string $format
     * @param string $size
     */
    public function __construct(string $path, string $format, string $size)
    {
        Assert::notEmpty($path);
        Assert::notEmpty($format);
        Assert::notEmpty($size);

        $this->path = $path;
        $this->format = $format;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }
}