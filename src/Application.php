<?php

declare(strict_types=1);

namespace Gocanto\PSQL;

use Gocanto\PSQL\Http\Router;
use Gocanto\PSQL\Provider\AppServiceProvider;
use Gocanto\PSQL\Provider\ProviderInterface;
use Laminas\Diactoros\ServerRequest;
use League\Container\Container;
use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;

final class Application
{
    private Router $router;

    /** @var ProviderInterface[] */
    private array $providers = [
        AppServiceProvider::class,
    ];

    public function __construct(private Container $container)
    {
        $this->registerProviders();
        $this->registerRoutes();
    }

    private function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $abstract = new $provider($this->container);
            $abstract->register();
        }
    }

    private function registerRoutes(): void
    {
        $strategy = new ApplicationStrategy();
        $strategy->setContainer($this->container);

        $this->router = new Router(new LeagueRouter(), $strategy);
    }

    public function handle(ServerRequest $request): void
    {
        $this->router->dispatch($request);
    }
}