<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

interface UserRepository
{
    public function findByLogin(Login $login): bool;
    public function findByEmail(Email $email): bool;
    public function existsByLogin(Login $login): bool;
    public function existsByEmail(Email $email): bool;
    public function add(User $user): void;
}