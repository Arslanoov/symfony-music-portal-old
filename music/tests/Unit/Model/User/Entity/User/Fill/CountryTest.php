<?php

declare(strict_types=1);

namespace App\Unit\Model\User\Entity\User\Fill;

use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\User;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->createUser();

        $this->assertNull($user->getInfo()->getCountry());

        $user->fillCountry($country = 'USA');

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
        return(new UserBuilder())
            ->withInfo(new Info(18))
            ->build();
    }
}