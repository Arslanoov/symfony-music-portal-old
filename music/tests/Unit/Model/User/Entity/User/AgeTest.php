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

class AgeTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createAdultUser();

        $this->assertTrue($user->getInfo()->isAdult());
        $this->assertFalse($user->getInfo()->isChild());

        $user = $this->createChildUser();

        $this->assertTrue($user->getInfo()->isChild());
        $this->assertFalse($user->getInfo()->isAdult());
    }

    private function createAdultUser(): User
    {
        return User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(18, 'about me', 'USA', Info::SEX_MALE)
        );
    }

    private function createChildUser(): User
    {
        return User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(16, 'about me', 'USA', Info::SEX_MALE)
        );
    }
}