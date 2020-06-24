<?php

declare(strict_types=1);

namespace App\ReadModel\User;

class DetailView
{
    public string $id;
    public string $date;
    public string $login;
    public string $email;
    public string $password;
    public ?string $info_about_me = null;
    public ?string $info_country = null;
    public ?string $info_sex = null;
    public int $info_age;
    public string $role;
    public string $status;
    public ?string $avatar;
}