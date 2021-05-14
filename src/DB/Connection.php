<?php

declare(strict_types=1);

namespace Gocanto\PSQL\DB;

use Gocanto\PSQL\Exception\DomainException;
use PDO;
use PDOException;

class Connection
{
    public function __construct(private Config $config)
    {
    }

    /**
     * @throws DomainException
     */
    public function connect(): PDO
    {
        try {
            $pdo = new PDO(
                $this->config->getDns(),
                $this->config->getUser(),
                $this->config->getPass(),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            throw new DomainException($e->getMessage(), $e->getCode(), $e);
        }

        return $pdo;
    }
}