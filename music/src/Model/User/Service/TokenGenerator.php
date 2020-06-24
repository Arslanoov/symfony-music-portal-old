<?php

declare(strict_types=1);

namespace App\Model\User\Service;

interface TokenGenerator
{
    public function generate(): string;
}