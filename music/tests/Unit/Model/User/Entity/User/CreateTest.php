<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

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
            $hash = 'hash',
            $info = new Info('about me', 'USA', 'male', '18')
        );

        $this->assertEquals($user->getId(), $id);
        $this->assertTrue($user->getId()->isEqual($id));
        $this->assertEquals($user->getLogin(), $login);
        $this->assertTrue($user->getLogin()->isEqual($login));
        $this->assertEquals($user->getEmail(), $email);
        $this->assertTrue($user->getEmail()->isEqual($email));
        $this->assertEquals($user->getPasswordHash(), $hash);
        $this->assertTrue($user->getInfo()->isEqual($info));
        $this->assertTrue($user->getStatus()->isWait());
    }
    
    public function testIncorrectEmail(): void
    {
        $this->expectExceptionMessage('Incorrect Email.');

        $user = User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('incorrect email'),
            $hash = 'hash',
            $info = new Info('about me', 'USA', 'male', '18')
        );
    }

    public function testEmptyLogin(): void
    {
        $this->expectExceptionMessage('Empty Login.');

        $user = User::signUpByEmail(
            $id = Id::next(),
            $login = new Login(''),
            $email = new Email('incorrect email'),
            $hash = 'hash',
            $info = new Info('about me', 'USA', 'male', '18')
        );
    }
}