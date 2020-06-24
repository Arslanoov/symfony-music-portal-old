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

class CountryTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $this->assertNull($user->getInfo()->getCountry());

        $user->fillCountry($country = Info::COUNTRIES[0]);

        $this->assertEquals($user->getInfo()->getCountry(), $country);
    }

    public function testEmpty(): void
    {
        $user = $this->createUser();

        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        $user->fillCountry($country = '');
    }

    public function testIncorrect(): void
    {
        $user = $this->createUser();

        $country = 'Ndhr2wvwsd';

        $this->expectExceptionMessage('Expected one of: "USA", "Russia", "Germany". Got: "' . $country . '"');

        $user->fillCountry($country);
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