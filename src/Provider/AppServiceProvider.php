<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Provider;

use Gocanto\PSQL\DB\Config;
use Gocanto\PSQL\DB\Connection;
use Gocanto\PSQL\Env;
use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Gocanto\PSQL\Repository\CarsRepository;
use League\Container\Container;

final class AppServiceProvider implements ProviderInterface
{
    private Env $env;
    private Container $container;

    public function register(): void
    {
        $this->container->add(IndexController::class)->addArgument(CarsRepository::class);
        $this->container->add(CarsRepository::class)->addArgument(new Connection(new Config($this->env)));
    }

    public function setEnv(Env $env): void
    {
        $this->env = $env;
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }
}
