<?php

declare(strict_types=1);

namespace App\Model\User\Service;

use RuntimeException;

class ArgonHasher implements HasherInterface
{
    public function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_ARGON2ID);

        if ($hash === false) {
            throw new RuntimeException('Unable to generate argon2id hash.');
        }

        return $hash;
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
