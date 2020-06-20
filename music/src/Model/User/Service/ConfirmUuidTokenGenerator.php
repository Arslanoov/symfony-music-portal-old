<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use App\Model\User\Entity\User\ConfirmToken;
use Exception;
use Ramsey\Uuid\Uuid;

class ConfirmUuidTokenGenerator implements TokenGenerator
{
    /**
     * @return ConfirmToken
     * @throws Exception
     */
    public function generate(): ConfirmToken
    {
        return new ConfirmToken(Uuid::uuid4()->toString());
    }
}