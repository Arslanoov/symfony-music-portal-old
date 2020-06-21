<?php

declare(strict_types=1);

namespace App\ReadModel\User;

use App\Exception\NotFoundException;
use App\Model\User\Entity\User\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class UserFetcher
{
    private Connection $connection;
    private ObjectRepository $repository;

    /**
     * UserFetcher constructor.
     * @param Connection $connection
     * @param EntityManagerInterface $em
     */
    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(User::class);
    }

    public function findForAuthByEmail(string $email): ?AuthView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'login',
                'email',
                'password',
                'role',
                'status'
            )
            ->from('user_users')
            ->where('email = :email')
            ->setParameter(':email', $email)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, AuthView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findByEmail(string $email): ?ShortView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'email',
                'role',
                'status'
            )
            ->from('user_users')
            ->where('email = :email')
            ->setParameter(':email', $email)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, ShortView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findBySignUpConfirmToken(string $token): ?ShortView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'email',
                'role',
                'status'
            )->from('user_users')
            ->where('confirm_token = :token')
            ->setParameter(':token', $token)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, ShortView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findDetail(string $id): ?DetailView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'login',
                'email',
                'password',
                'info_about_me',
                'info_country',
                'info_sex',
                'info_age',
                'role',
                'status'
            )->from('user_users')
            ->where('id = :id')
            ->setParameter(':id', $id)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, DetailView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function getDetail(string $id): DetailView
    {
        if (!$detail = $this->findDetail($id)) {
            throw new NotFoundException('User is not found.');
        }

        return $detail;
    }

    public function get(string $id): User
    {
        if (!$user = $this->repository->find($id)) {
            throw new NotFoundException('User is not found.');
        }

        /** @var User $user */

        return $user;
    }
}