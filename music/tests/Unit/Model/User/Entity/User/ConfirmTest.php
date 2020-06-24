<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
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
        return (new UserBuilder())
            ->withInfo(new Info(18, 'about me', 'country', Info::SEX_MALE))
            ->build();
    }
}