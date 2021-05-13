<?php

declare(strict_types=1);

namespace Gocanto\PSQL;

use Gocanto\PSQL\Http\Router;
use Gocanto\PSQL\Http\RouterResolver;
use Illuminate\Container\Container;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Application extends Container
{
    private Router $router;

    public static function create(): self
    {
        $app = new self();
        $app->router = new Router(new RouteCollector());

        return $app;
    }

    public function handle(Request $request): Response
    {
        $dispatcher = new Dispatcher($this->router->getData(), new RouterResolver(Container::getInstance()));

        try {
            $content = $dispatcher->dispatch($request->getRealMethod(), parse_url($request->getUri(), PHP_URL_PATH));
        } catch (Throwable $throwable) {
            return new Response(Whoops::render($throwable), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $content instanceof Response ? $content : new Response($content);
    }
}