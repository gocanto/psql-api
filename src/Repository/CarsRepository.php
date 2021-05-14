<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Repository;

use Gocanto\PSQL\DB\Connection;
use Gocanto\PSQL\Exception\DomainException;

class CarsRepository
{
    public function __construct(private Connection $connection)
    {
    }

    /**
     * @throws DomainException
     */
    public function all(): array
    {
        return [
            'toyota' => 'corolla',
            'ford' => 'ka',
            'connected' => $this->connection->connect() ? 'yes' : 'no',
        ];
    }
}
