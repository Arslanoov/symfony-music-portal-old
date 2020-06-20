<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class Role
{
    private const ROLE_USER = 'User';
    private const ROLE_MODERATOR = 'Moderator';
    private const ROLE_CONTENT_MANAGER = 'Content Manager';
    private const ROLE_ADMIN = 'Admin';

    private string $value;

    /**
     * Role constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::ROLE_USER,
            self::ROLE_CONTENT_MANAGER,
            self::ROLE_MODERATOR,
            self::ROLE_ADMIN
        ]);

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public static function user(): self
    {
        return new self(self::ROLE_USER);
    }

    public static function moderator(): self
    {
        return new self(self::ROLE_MODERATOR);
    }

    public static function contentManager(): self
    {
        return new self(self::ROLE_CONTENT_MANAGER);
    }

    public static function admin(): self
    {
        return new self(self::ROLE_ADMIN);
    }

    public function isUser(): bool
    {
        return $this->value === self::ROLE_USER;
    }

    public function isModerator(): bool
    {
        return $this->value === self::ROLE_MODERATOR;
    }

    public function isContentManager(): bool
    {
        return $this->value === self::ROLE_CONTENT_MANAGER;
    }

    public function isAdmin(): bool
    {
        return $this->value === self::ROLE_ADMIN;
    }

    public function isEqual(Role $role): bool
    {
        return $this->value === $role->getValue();
    }
}