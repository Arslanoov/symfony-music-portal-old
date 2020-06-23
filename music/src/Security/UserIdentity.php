<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\User\Entity\User\Status;
use App\Model\User\Entity\User\User;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserIdentity implements UserInterface, EquatableInterface
{
    private string $id;
    private string $login;
    private string $email;
    private string $password;
    private string $role;
    private string $status;

    public function __construct(
        string $id,
        string $login,
        string $email,
        string $password,
        string $role,
        string $status
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function isWait(): bool
    {
        return $this->status === Status::STATUS_WAIT;
    }

    public function isBanned(): bool
    {
        return $this->status === Status::STATUS_BANNED;
    }

    public function isActive(): bool
    {
        return $this->status === Status::STATUS_ACTIVE;
    }

    public function getUsername(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return [
            $this->role
        ];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void {}

    public function isEqualTo(UserInterface $user): bool
    {
        if (!$user instanceof self) {
            return false;
        }

        return
            $this->id === $user->id and
            $this->login === $user->login and
            $this->password === $user->password and
            $this->role === $user->role and
            $this->status === $user->status
        ;
    }
}
