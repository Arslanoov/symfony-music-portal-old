<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Avatar;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class AvatarTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $user->uploadAvatar(new Avatar(
            $path = 'path'
        ));

        $this->assertEquals($user->getAvatar()->getValue(), $path);

        $user->removeAvatar();

        $this->assertNull($user->getAvatar());
    }

    private function createUser(): User
    {
        return (new UserBuilder())
            ->withInfo(new Info(18, 'about me', 'country', Info::SEX_MALE))
            ->build();
    }
}