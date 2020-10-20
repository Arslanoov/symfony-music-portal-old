<?php

declare(strict_types=1);

namespace App\Service\Transaction;

use Doctrine\DBAL\ConnectionException;

interface TransactionInterface
{
    public function begin(): void;

    /**
     * @throws ConnectionException
     */
    public function commit(): void;

    /**
     * @throws ConnectionException
     */
    public function rollback(): void;
}
