<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class Info
{
    public const SEX_MALE = 'Male';
    public const SEX_FEMALE = 'Female';

    private ?string $aboutMe = null;
    private ?string $country = null;
    private ?string $sex = null;
    private int $age;

    /**
     * Info constructor.
     * @param string $aboutMe
     * @param string $country
     * @param string $sex
     * @param int $age
     */
    public function __construct(int $age, string $aboutMe = null, string $country = null, string $sex = null)
    {
        Assert::notEmpty($age);
        Assert::oneOf($sex, [
            self::SEX_MALE,
            self::SEX_FEMALE
        ]);

        $this->aboutMe = $aboutMe;
        $this->country = $country;
        $this->sex = $sex;
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getAboutMe(): string
    {
        return $this->aboutMe;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    public function isAdult(): bool
    {
        return $this->age >= 18;
    }

    public function isChild(): bool
    {
        return $this->age < 18;
    }

    public function isMale(): bool
    {
        return $this->sex === self::SEX_MALE;
    }

    public function isFemale(): bool
    {
        return $this->sex === self::SEX_FEMALE;
    }

    /**
     * @return string|null
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function isEqual(Info $info): bool
    {
        return
            $this->aboutMe === $info->getAboutMe() and
            $this->country === $info->getCountry() and
            $this->sex === $info->getSex() and
            $this->age === $info->getAge()
        ;
    }
}