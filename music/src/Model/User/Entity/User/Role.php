<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class Role
{
    public const USER = 'ROLE_USER';
    public const MODERATOR = 'ROLE_MODERATOR';
    public const CONTENT_MANAGER = 'ROLE_CONTENT_MANAGER';
    public const ADMIN = 'ROLE_ADMIN';

    private string $value;

    /**
     * Role constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::USER,
            self::CONTENT_MANAGER,
            self::MODERATOR,
            self::ADMIN
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
        return new self(self::USER);
    }

    public static function moderator(): self
    {
        return new self(self::MODERATOR);
    }

    public static function contentManager(): self
    {
        return new self(self::CONTENT_MANAGER);
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public function isUser(): bool
    {
        return $this->value === self::USER;
    }

    public function isModerator(): bool
    {
        return $this->value === self::MODERATOR;
    }

    public function isContentManager(): bool
    {
        return $this->value === self::CONTENT_MANAGER;
    }

    public function isAdmin(): bool
    {
        return $this->value === self::ADMIN;
    }

    public function isEqual(Role $role): bool
    {
        return $this->value === $role->getValue();
    }
}