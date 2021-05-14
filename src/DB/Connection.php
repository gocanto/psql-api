<?php

declare(strict_types=1);

namespace Gocanto\PSQL\DB;

use PDO;
use PDOException;

class Connection
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @throws DatabaseException
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
            throw new DatabaseException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $pdo;
    }
}
