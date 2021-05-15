<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Tests;

use Carbon\CarbonImmutable;
use Gocanto\PSQL\Entity\Car;
use Gocanto\PSQL\Entity\CarsCollection;
use Gocanto\PSQL\Repository\CarsRepository;
use Mockery;

final class Mock
{
    public static function carsCollection(?CarbonImmutable $date = null): CarsCollection
    {
        $date ??= CarbonImmutable::now();

        $collection = new CarsCollection();
        $car = new Car([
            'id' => \mt_rand(),
            'model' => '_model_',
            'type' => '_type',
            'brand' => '_brand_',
            'year' => '_year_',
            'created_at' => $date->toDateTimeString(),
            'updated_at' => $date->toDateTimeString(),
        ]);

        $collection->add($car);

        return $collection;
    }

    public static function carsRepository(): CarsRepository | Mockery\MockInterface | Mockery\LegacyMockInterface
    {
        return Mockery::mock(CarsRepository::class);
    }
}
