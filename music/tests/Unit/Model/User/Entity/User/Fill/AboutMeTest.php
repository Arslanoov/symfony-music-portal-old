<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User\Fill;

use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
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
        return (new UserBuilder())
            ->withInfo(new Info(18))
            ->build();
    }
}