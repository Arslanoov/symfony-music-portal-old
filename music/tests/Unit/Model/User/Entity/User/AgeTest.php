<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
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
        return (new UserBuilder())
            ->withInfo(new Info(18))
            ->build();
    }

    private function createChildUser(): User
    {
        return (new UserBuilder())
            ->withInfo(new Info(16))
            ->build();
    }
}