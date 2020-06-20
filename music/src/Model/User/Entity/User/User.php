<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

class User
{
    private Id $id;
    private Login $login;
    private Email $email;
    private Info $info;
    private Password $password;
    private Status $status;

    ### create ###

    public function __construct(Id $id, Login $login, Email $email, Password $password, Info $info, Status $status)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->info = $info;
        $this->password = $password;
        $this->status = $status;
    }

    public static function signUpByEmail(
        Id $id, Login $login,
        Email $email, Password $password, Info $info
    ): self
    {
        return new self(
            $id, $login, $email,
            $password, $info, Status::wait()
        );
    }

    ### getters ###

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Login
     */
    public function getLogin(): Login
    {
        return $this->login;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Info
     */
    public function getInfo(): Info
    {
        return $this->info;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }
}