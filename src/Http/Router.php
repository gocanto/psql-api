<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\RouteDataArray;

final class Router
{
    public function __construct(private RouteCollector $collector)
    {
        $this->registerCarsRoutes();
    }

    private function registerCarsRoutes(): void
    {
        $this->collector->group(['prefix' => 'api'], function (RouteCollector $router) {
            $router->get('/', function() {
                return 'This route responds to any method (POST, GET, DELETE etc...) at the URI /example';
            });

            $router->get('/cars', [IndexController::class, 'handle']);
        });
    }

    public function getData(): RouteDataArray
    {
        return $this->collector->getData();
    }
}