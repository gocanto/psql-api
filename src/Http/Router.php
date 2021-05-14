<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Laminas\Diactoros\ServerRequest;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\RouteGroup;
use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;

final class Router
{
    private LeagueRouter $router;

    public function __construct(LeagueRouter $router, ApplicationStrategy $strategy)
    {
        $this->router = $router;
        $this->router->setStrategy($strategy);

        $this->registerCarsRoutes();
    }

    private function registerCarsRoutes(): void
    {
        $this->router->group('api', static function (RouteGroup $router): void {
            $router->map('GET', '/cars', IndexController::class);
        });
    }

    public function dispatch(ServerRequest $request): void
    {
        $response = $this->router->dispatch($request);

        (new SapiEmitter())->emit($response);
    }
}
