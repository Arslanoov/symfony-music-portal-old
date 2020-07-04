<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class ProfileViewsTest extends TestCase
{
    public function testIncrease(): void
    {
        $user = $this->createUser();

        $this->assertEquals($user->getProfileViews(), 0);

        $user->increaseProfileViews();

        $this->assertEquals($user->getProfileViews(), 1);
    }

    private function createUser(): User
    {
        return (new UserBuilder())
            ->build();
    }

}