<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\SignUp\ByEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     */
    public string $id;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="32")
     */
    public string $login;
    /**
     * @var string
     * @Assert\Email()
     * @Assert\Length(min="4", max="64")
     */
    public string $email;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="32")
     */
    public string $password;
    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(7)
     * @Assert\LessThan(99)
     */
    public int $age;

    /**
     * Command constructor.
     * @param string $id
     * @param string $login
     * @param string $email
     * @param string $password
     * @param int $age
     */
    public function __construct(string $id, string $login, string $email, string $password, int $age)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->age = $age;
    }
}
