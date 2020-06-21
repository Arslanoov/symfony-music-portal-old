<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserRepository
{
    private ObjectRepository $repository;
    private EntityManagerInterface $em;

    /**
     * UserRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(User::class);
        $this->em = $em;
    }

    public function findByLogin(Login $login): ?User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy([
            'login' => $login->getValue()
        ]);

        return $user;
    }

    public function findByEmail(Email $email): ?User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy([
            'email' => $email->getValue()
        ]);

        return $user;
    }

    public function findByConfirmToken(ConfirmToken $token): ?User
    {
        /** @var User $user */
        $user = $this->repository->findOneBy([
            'confirm_token' => $token->getValue()
        ]);

        return $user;
    }

    public function existsByLogin(Login $login): bool
    {
        return (bool) $this->findByLogin($login);
    }

    public function existsByEmail(Email $email): bool
    {
        return (bool) $this->findByEmail($email);
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }
}