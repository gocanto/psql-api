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
            $cars->add(new Car($this->mapCarData($row)));
        }

        return $cars;
    }

    public function findById(int $id): ?Car
    {
        $query = $this->db->prepare('SELECT * FROM cars WHERE id = :id LIMIT 1');
        $query->bindValue(':id', $id);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return new Car($this->mapCarData($row));
    }

    public function update(int $id, array $attributes): Car
    {
        $statement = '';

        foreach ($attributes as $attribute) {
            $statement .= "{$attribute['field']} = :{$attribute['field']}, ";
        }

        $statement = \rtrim($statement, ', ');
        $statement = "UPDATE cars SET {$statement} WHERE id = :id";

        $query = $this->db->prepare($statement);

        foreach ($attributes as $attribute) {
            $query->bindValue(':' . $attribute['field'], $attribute['value']);
        }

        $query->bindValue(':id', $id);
        $query->execute();

        return $this->findById($id);
    }

    private function mapCarData(array $row): array
    {
        return [
            'id' => $row['id'],
            'model' => $row['model_name'],
            'type' => $row['model_type'],
            'brand' => $row['model_brand'],
            'year' => $row['model_year'],
            'created_at' => $row['model_date_added'],
            'updated_at' => $row['model_date_modified'],
        ];
    }
}
