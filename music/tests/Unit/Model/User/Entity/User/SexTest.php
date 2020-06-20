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
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(18, 'about me', 'USA', Info::SEX_MALE)
        );
    }

    private function createFemaleUser(): User
    {
        return User::signUpByEmail(
            $id = Id::next(),
            $login = new Login('User login'),
            $email = new Email('user@email.com'),
            $password = new Password('hash'),
            $info = new Info(18, 'about me', 'USA', Info::SEX_FEMALE)
        );
    }
}