<?php

declare(strict_types=1);

namespace App\Tests\Functional\Auth\SignUp;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Status;
use App\Tests\Builder\User\UserBuilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ConfirmFixture extends Fixture
{
    public const SUCCESS_REFERENCE = 'test_sign_up_confirm_success';

    public function load(ObjectManager $manager): void
    {
        $notConfirmed = (new UserBuilder())
            ->withLogin(new Login('someUserLogin'))
            ->withEmail(new Email('someUser@app.test'))
            ->withConfirmToken(new ConfirmToken('success_token'))
            ->build()
        ;

        $manager->persist($notConfirmed);

        $this->setReference(self::SUCCESS_REFERENCE, $notConfirmed);

        $manager->flush();
    }
}
