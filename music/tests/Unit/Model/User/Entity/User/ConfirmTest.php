<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $this->assertNotEmpty($user->getConfirmToken());
        $this->assertTrue($user->getStatus()->isWait());
        $this->assertFalse($user->getStatus()->isActive());

        $user->confirmSignUp();

        $this->assertNull($user->getConfirmToken());
        $this->assertTrue($user->getStatus()->isActive());
        $this->assertFalse($user->getStatus()->isWait());
    }

    public function testAlready(): void
    {
        $user = $this->createUser();

        $user->confirmSignUp();

        $this->expectExceptionMessage('User is already activated.');

        $user->confirmSignUp();
    }

    public function createUser(): User
    {
        return User::signUpByEmail(
            Id::next(),
            new Login('Login'),
            new Email('user@email.com'),
            new Password('hash'),
            new Info(18, 'about me', 'USA', Info::SEX_MALE),
            new ConfirmToken('token')
        );
    }
}