<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(18, 'about me', 'USA', Info::SEX_MALE)
        );

        $this->assertEquals($user->getId(), $id);
        $this->assertTrue($user->getId()->isEqual($id));
        $this->assertEquals($user->getLogin(), $login);
        $this->assertTrue($user->getLogin()->isEqual($login));
        $this->assertEquals($user->getEmail(), $email);
        $this->assertTrue($user->getEmail()->isEqual($email));
        $this->assertEquals($user->getPassword(), $password);
        $this->assertTrue($user->getInfo()->isEqual($info));
        $this->assertTrue($user->getStatus()->isWait());
        $this->assertTrue($user->getInfo()->isAdult());
    }

    public function testIncorrectEmail(): void
    {
        $this->expectExceptionMessage('Incorrect Email.');

        $user = User::signUpByEmail(
            Id::next(),
            new Login('User login'),
            new Email('incorrect email'),
            new Password('hash'),
            new Info(18, 'about me', 'USA', Info::SEX_MALE)
        );
    }

    public function testEmptyLogin(): void
    {
        $this->expectExceptionMessage('Empty Login.');

        $user = User::signUpByEmail(
            Id::next(),
            new Login(''),
            new Email('user@email.com'),
            new Password('hash'),
            new Info(18, 'about me', 'USA', Info::SEX_MALE)
        );
    }
}