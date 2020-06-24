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

class SexTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $this->assertNull($user->getInfo()->getCountry());

        $user->fillSex($sex = Info::SEX_MALE);

        $this->assertEquals($user->getInfo()->getSex(), $sex);
    }

    public function testEmpty(): void
    {
        $user = $this->createUser();

        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        $user->fillSex($sex = '');
    }

    public function testIncorrect(): void
    {
        $user = $this->createUser();

        $sex = 'Bigender';

        $this->expectExceptionMessage('Expected one of: "Male", "Female". Got: "' . $sex . '"');

        $user->fillSex($sex);
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