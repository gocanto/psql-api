<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Gocanto\PSQL\Http\Controllers\Cars\DeleteController;
use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Gocanto\PSQL\Http\Controllers\Cars\ShowController;
use Gocanto\PSQL\Http\Controllers\Cars\StoreController;
use Gocanto\PSQL\Http\Controllers\Cars\UpdateController;
use Laminas\Diactoros\ServerRequest;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\RouteGroup;
use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;

final class Router
{
    private LeagueRouter $router;
    private SapiEmitter $emitter;

    public function __construct(LeagueRouter $router, ApplicationStrategy $strategy, SapiEmitter $emitter)
    {
        $this->router = $router;
        $this->router->setStrategy($strategy);

        $this->registerCarsRoutes();
        $this->emitter = $emitter;
    }

    private function registerCarsRoutes(): void
    {
        $this->router->group('api', static function (RouteGroup $router): void {
            $router->map('POST', '/cars', StoreController::class);
            $router->map('GET', '/cars', IndexController::class);
            $router->map('GET', '/cars/{id:number}', ShowController::class);
            $router->map('PUT', '/cars/{id:number}', UpdateController::class);
            $router->map('DELETE', '/cars/{id:number}', DeleteController::class);
        });
    }

    public function dispatch(ServerRequest $request): void
    {
        $response = $this->router->dispatch($request);

        $this->emitter->emit($response);
    }
}
