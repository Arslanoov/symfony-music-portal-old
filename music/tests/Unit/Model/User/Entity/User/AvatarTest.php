<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Avatar;
use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class AvatarTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $user->uploadAvatar(new Avatar(
            $path = 'path'
        ));

        $this->assertEquals($user->getAvatar()->getValue(), $path);

        $user->removeAvatar();

        $this->assertNull($user->getAvatar());
    }

    private function createUser(): User
    {
        return User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(18, 'about me', 'USA', Info::SEX_MALE),
            $token = new ConfirmToken('token')
        );
    }
}