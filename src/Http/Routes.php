<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Exception;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class Routes
{
    /**
     * @throws Exception
     */
    public static function compiled(): array
    {
        $collection = new RouteCollection();

        self::registerCars($collection);

        return (new CompiledUrlMatcherDumper($collection))->getCompiledRoutes();
    }

    private static function registerCars(RouteCollection $collection): void
    {
        $collection->add('cars', new Route('/cars'));
    }

    private function __construct()
    {
    }
}