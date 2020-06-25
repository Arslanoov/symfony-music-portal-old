<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Genre;

use Ausi\SlugGenerator\SlugGenerator;

class Slug
{
    public string $value;

    /**
     * Slug constructor.
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function raw(string $value): self
    {
        return new self($value);
    }

    public static function generate(string $value): self
    {
        $slug = (new SlugGenerator())->generate($value);
        return new self($slug);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Slug $slug): bool
    {
        return $this->value === $slug->getValue();
    }
}