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

class AboutMeTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $this->assertNull($user->getInfo()->getAboutMe());

        $user->fillAboutMe($aboutMe = 'AboutMe');

        $this->assertEquals($user->getInfo()->getAboutMe(), $aboutMe);
    }

    public function testEmpty(): void
    {
        $user = $this->createUser();

        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        $user->fillAboutMe($aboutMe = '');
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