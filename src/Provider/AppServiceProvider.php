<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Provider;

use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Gocanto\PSQL\Repository\CarsRepository;
use League\Container\Container;

final class AppServiceProvider implements ProviderInterface
{
    public function __construct(private Container $container)
    {
    }

    public function register(): void
    {
        $this->container->add(IndexController::class)->addArgument(CarsRepository::class);
        $this->container->add(CarsRepository::class);
    }
}