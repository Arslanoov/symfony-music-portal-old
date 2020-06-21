<?php

declare(strict_types=1);

namespace App\ReadModel\User;

class AuthView
{
    public string $id;
    public string $login;
    public string $email;
    public string $password;
    public string $role;
    public string $status;
}