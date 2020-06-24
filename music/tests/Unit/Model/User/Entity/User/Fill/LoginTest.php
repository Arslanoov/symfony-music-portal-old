<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User\Fill;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $this->assertNotNull($user->getLogin()->getValue());

        $user->changeLogin($login = new Login('New login'));

        $this->assertEquals($user->getLogin()->getValue(), $login->getValue());
    }

    public function testEqual(): void
    {
        $user = $this->createUser();

        $this->expectExceptionMessage('Login matches previous login.');

        $user->changeLogin($login = new Login('User login'));
    }

    private function createUser(): User
    {
        return User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(18),
            $token = new ConfirmToken('token')
        );
    }
}