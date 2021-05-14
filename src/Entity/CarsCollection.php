<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Entity;

final class CarsCollection
{
    /** @var Car[] $cars */
    private array $cars;

    public function add(Car $car): void
    {
        $this->cars[$car->getId()] = $car;
    }

    public function count(): int
    {
        return \count($this->cars);
    }

    public function toArray(): array
    {
        $cars = [];

        foreach ($this->cars as $car) {
            $cars[] = $car->toArray();
        }

        return $cars;
    }
}
