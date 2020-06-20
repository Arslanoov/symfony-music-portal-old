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

class SexTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createMaleUser();

        $this->assertTrue($user->getInfo()->isMale());
        $this->assertFalse($user->getInfo()->isFemale());

        $user = $this->createFemaleUser();

        $this->assertTrue($user->getInfo()->isFemale());
        $this->assertFalse($user->getInfo()->isMale());
    }

    private function createMaleUser(): User
    {
        return User::signUpByEmail(
            Id::next(),
            new Login('User login'),
            new Email('user@email.com'),
            new Password('hash'),
            new Info(18, 'about me', 'USA', Info::SEX_MALE),
            new ConfirmToken('token')
        );
    }

    private function createFemaleUser(): User
    {
        return User::signUpByEmail(
            Id::next(),
            new Login('User login'),
            new Email('user@email.com'),
            new Password('hash'),
            new Info(18, 'about me', 'USA', Info::SEX_FEMALE),
            new ConfirmToken('token')
        );
    }
}