<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Repository;

use Gocanto\PSQL\DB\Connection;
use Gocanto\PSQL\DB\DatabaseException;
use Gocanto\PSQL\Entity\Car;
use Gocanto\PSQL\Entity\CarsCollection;
use PDO;

class CarsRepository
{
    private PDO $db;

    /**
     * @throws DatabaseException
     */
    public function __construct(Connection $connection)
    {
        $this->db = $connection->connect();
    }

    public function getAll(int $limit = 50): CarsCollection
    {
        $query = $this->db->prepare('
            SELECT *
            FROM cars
            WHERE model_date_added IS NOT NULL AND model_date_modified IS NOT NULL
            LIMIT  :limit
        ');

        $query->bindValue(':limit', $limit);
        $query->execute();

        $cars = new CarsCollection();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $cars->add(new Car([
                'id' => $row['id'],
                'model' => $row['model_name'],
                'type' => $row['model_type'],
                'brand' => $row['model_brand'],
                'year' => $row['model_year'],
                'created_at' => $row['model_date_added'],
                'updated_at' => $row['model_date_modified'],
            ]));
        }

        return $cars;
    }
}
