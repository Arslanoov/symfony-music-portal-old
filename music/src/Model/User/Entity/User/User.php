<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use DateTimeImmutable;
use DomainException;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * Class User
 * @package App\Model\User\Entity\User
 * @ORM\Entity()
 * @ORM\Table(name="user_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"login"}),
 *     @ORM\UniqueConstraint(columns={"email"}),
 *     @ORM\UniqueConstraint(columns={"confirm_token_token"})
 * })
 */
class User
{
    /**
     * @var Id
     * @ORM\Id()
     * @ORM\Column(type="user_user_id")
     */
    private Id $id;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @var Login
     * @ORM\Column(type="user_user_login", length=32)
     */
    private Login $login;
    /**
     * @var Email
     * @ORM\Column(type="user_user_email")
     */
    private Email $email;
    /**
     * @var Avatar
     * @ORM\Column(type="user_user_avatar", length=128, nullable=true)
     */
    private ?Avatar $avatar = null;
    /**
     * @var Info
     * @ORM\Embedded(class="Info", columnPrefix="info_")
     */
    private Info $info;
    /**
     * @var Password
     * @ORM\Column(type="user_user_password", length=128)
     */
    private Password $password;
    /**
     * @var Status
     * @ORM\Column(type="user_user_status", length=16)
     */
    private Status $status;
    /**
     * @var ConfirmToken|null
     * @ORM\Column(type="user_user_confirm_token", name="confirm_token_token", length=128, nullable=true)
     */
    private ?ConfirmToken $confirmToken = null;
    /**
     * @var Role
     * @ORM\Column(type="user_user_role", length=16)
     */
    private Role $role;

    ### create ###

    public function __construct(
        Id $id, DateTimeImmutable $date, Login $login, Email $email,
        Password $password, Info $info,
        Status $status, Role $role, ?ConfirmToken $confirmToken = null
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->login = $login;
        $this->email = $email;
        $this->info = $info;
        $this->password = $password;
        $this->status = $status;
        $this->role = $role;
        $this->confirmToken = $confirmToken;
    }

    public static function signUpByEmail(
        Id $id, DateTimeImmutable $date, Login $login,
        Email $email, Password $password, Info $info,
        ConfirmToken $confirmToken
    ): self
    {
        return new self(
            $id, $date, $login, $email,
            $password, $info, Status::wait(),
            Role::user(), $confirmToken
        );
    }

    public function confirmSignUp(): void
    {
        if (
            $this->status->isActive() or
            $this->confirmToken === null
        ) {
            throw new DomainException('User is already activated.');
        }

        $this->status = Status::active();
        $this->confirmToken = null;
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

    /**
     * @return ConfirmToken|null
     */
    public function getConfirmToken(): ?ConfirmToken
    {
        return $this->confirmToken;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return Avatar|null
     */
    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    ### actions

    public function uploadAvatar(Avatar $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function removeAvatar(): void
    {
        $this->avatar = null;
    }

    public function changeLogin(Login $login): void
    {
        if ($this->getLogin()->isEqual($login)) {
            throw new DomainException('Login matches previous login.');
        }

        $this->login = $login;
    }

    public function fillAboutMe(string $aboutMe): void
    {
        Assert::notEmpty($aboutMe);

        $this->info = new Info(
            $this->info->getAge(),
            $aboutMe,
            $this->info->getCountry(),
            $this->info->getSex()
        );
    }

    public function fillCountry(string $country): void
    {
        Assert::notEmpty($country);
        Assert::oneOf($country, Info::COUNTRIES);

        $this->info = new Info(
            $this->info->getAge(),
            $this->info->getAboutMe(),
            $country,
            $this->info->getSex()
        );
    }

    public function fillSex(string $sex): void
    {
        Assert::notEmpty($sex);

        Assert::oneOf($sex, [
            Info::SEX_MALE,
            Info::SEX_FEMALE
        ]);

        $this->info = new Info(
            $this->info->getAge(),
            $this->info->getAboutMe(),
            $this->info->getCountry(),
            $sex
        );
    }
}