<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ResetPasswordToken
 * @package App\Model\User\Entity\User
 * @ORM\Embeddable()
 */
class ResetPasswordToken
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, length=64)
     */
    public ?string $token = null;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $expireDate = null;

    /**
     * ConfirmToken constructor.
     * @param string $token
     * @param DateTimeImmutable $expireDate
     */
    public function __construct(string $token, DateTimeImmutable $expireDate)
    {
        Assert::notEmpty($token);
        $this->token = $token;
        $this->expireDate = $expireDate;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getExpireDate(): DateTimeImmutable
    {
        return $this->expireDate;
    }

    public function isExpiredNow(): bool
    {
        return $this->expireDate <= new DateTimeImmutable();
    }

    public function isExpired(DateTimeImmutable $to): bool
    {
        return $this->expireDate <= $to;
    }

    public function isNotExpired(DateTimeImmutable $to): bool
    {
        return !$this->isExpired($to);
    }

    public function isEqual(ResetPasswordToken $token): bool
    {
        return
            $this->token === $token->getToken() and
            $this->expireDate === $token->getExpireDate()
        ;
    }
}