<?php

declare(strict_types=1);

namespace App\Service\Transaction;

use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTransaction implements TransactionInterface
{
    private EntityManagerInterface $em;

    /**
     * DoctrineTransaction constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function begin(): void
    {
        $this->em->getConnection()->beginTransaction();
    }

    public function commit(): void
    {
        $this->em->getConnection()->commit();
    }

    public function rollback(): void
    {
        $this->em->getConnection()->rollBack();
    }
}
