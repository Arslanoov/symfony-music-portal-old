<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\ConfirmToken;

interface TokenGenerator
{
    public function generate(): ConfirmToken;
}