<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\Status;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class PasswordResetTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $user->requestPasswordReset($token = 'token', $date = new DateTimeImmutable());

        $this->assertEquals($user->getResetPasswordToken()->getToken(), $token);
        $this->assertEquals($user->getResetPasswordToken()->getExpireDate(), $date);

        $user->changePassword($password = new Password('new password'));

        $this->assertEquals($user->getPassword()->getValue(), $password->getValue());
    }

    private function createUser(): User
    {
        return (new UserBuilder())
            ->withStatus(Status::active())
            ->build();
    }
}