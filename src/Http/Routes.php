<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Routes
{
    public static function make(): RouteCollection
    {
        $routes = new RouteCollection();

        $routes->add('hello', new Route('/hello/{name}', ['name' => 'World']));

        return $routes;
    }
}