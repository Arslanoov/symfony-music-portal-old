<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User\Fill;

use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
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
        return (new UserBuilder())
            ->withInfo(new Info(18))
            ->build();
    }
}