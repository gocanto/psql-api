<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Illuminate\Container\Container;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\RouteDataArray;

final class Router
{
    private RouteCollector $collector;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->collector = new RouteCollector();

        $this->registrar();
    }

    private function registrar(): void
    {
        $this->collector->group(['prefix' => 'api'], function (RouteCollector $router) {
            $router->get('/', function() {
                return 'This route responds to any method (POST, GET, DELETE etc...) at the URI /example';
            });
        });
    }

    public function getData(): RouteDataArray
    {
        return $this->collector->getData();
    }
}