<?php

declare(strict_types=1);

namespace App\Tests\Builder\User;

use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\Status;
use App\Model\User\Entity\User\User;
use DateTimeImmutable;
use Exception;

class UserBuilder
{
    private Id $id;
    private DateTimeImmutable $date;
    private Login $login;
    private Email $email;
    private Info $info;
    private Password $password;
    private Status $status;
    private ?ConfirmToken $confirmToken = null;
    private Role $role;

    /**
     * UserBuilder constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->id = Id::next();
        $this->date = new DateTimeImmutable();
        $this->login = new Login('User login');
        $this->email = new Email('user@email.com');
        $this->info = new Info(18);
        $this->password = new Password('hash');
        $this->status = Status::wait();
        $this->confirmToken = new ConfirmToken('token');
        $this->role = Role::user();
    }

    public function withId(Id $id): self
    {
        $builder = clone $this;
        $builder->id = $id;
        return $builder;
    }

    public function withDate(DateTimeImmutable $date): self
    {
        $builder = clone $this;
        $builder->date = $date;
        return $builder;
    }

    public function withLogin(Login $login): self
    {
        $builder = clone $this;
        $builder->login = $login;
        return $builder;
    }

    public function withEmail(Email $email): self
    {
        $builder = clone $this;
        $builder->email = $email;
        return $builder;
    }

    public function withPassword(Password $password): self
    {
        $builder = clone $this;
        $builder->password = $password;
        return $builder;
    }

    public function withInfo(Info $info): self
    {
        $builder = clone $this;
        $builder->info = $info;
        return $builder;
    }

    public function withStatus(Status $status): self
    {
        $builder = clone $this;
        $builder->status = $status;
        return $builder;
    }

    public function withRole(Role $role): self
    {
        $builder = clone $this;
        $builder->role = $role;
        return $builder;
    }

    public function withConfirmToken(?ConfirmToken $confirmToken): self
    {
        $builder = clone $this;
        $builder->confirmToken = $confirmToken;
        return $builder;
    }

    public function build(): User
    {
        return new User(
            $this->id,
            $this->date,
            $this->login,
            $this->email,
            $this->password,
            $this->info,
            $this->status,
            $this->role,
            $this->confirmToken
        );
    }
}
