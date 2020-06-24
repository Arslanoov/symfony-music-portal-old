<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Tests\Builder\User\UserBuilder;
use App\Model\User\Entity\User\Info;
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
        return (new UserBuilder())
            ->withInfo(new Info(18, 'about me', 'country', Info::SEX_MALE))
            ->build();
    }

    private function createFemaleUser(): User
    {
        return (new UserBuilder())
            ->withInfo(new Info(18, 'about me', 'country', Info::SEX_FEMALE))
            ->build();
    }
}