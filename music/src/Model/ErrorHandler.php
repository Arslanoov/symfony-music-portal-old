<?php

declare(strict_types=1);

namespace App\Model;

use DomainException;
use Psr\Log\LoggerInterface;

class ErrorHandler
{
    private LoggerInterface $logger;

    /**
     * ErrorHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handleWarning(DomainException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}