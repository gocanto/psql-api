<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Provider;

use Gocanto\PSQL\DB\Config;
use Gocanto\PSQL\DB\Connection;
use Gocanto\PSQL\Env;
use Gocanto\PSQL\Http\Controllers\Cars\DeleteController;
use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Gocanto\PSQL\Http\Controllers\Cars\ShowController;
use Gocanto\PSQL\Http\Controllers\Cars\StoreController;
use Gocanto\PSQL\Http\Controllers\Cars\UpdateController;
use Gocanto\PSQL\Repository\CarsRepository;
use League\Container\Container;

final class AppServiceProvider implements ProviderInterface
{
    private Env $env;
    private Container $container;

    public function register(): void
    {
        $this->registerBindings();
    }

    public function setEnv(Env $env): void
    {
        $this->env = $env;
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    private function registerBindings(): void
    {
        $this->container->add(IndexController::class)->addArgument(CarsRepository::class);
        $this->container->add(StoreController::class)->addArgument(CarsRepository::class);
        $this->container->add(ShowController::class)->addArgument(CarsRepository::class);
        $this->container->add(UpdateController::class)->addArgument(CarsRepository::class);
        $this->container->add(DeleteController::class)->addArgument(CarsRepository::class);

        $this->container->add(CarsRepository::class)->addArgument(new Connection(new Config($this->env)));
    }
}
