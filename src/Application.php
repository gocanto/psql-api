<?php

declare(strict_types=1);

namespace Gocanto\PSQL;

use Gocanto\PSQL\Http\Router;
use Illuminate\Container\Container;
use Phroute\Phroute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Application extends Container
{
    private Router $router;

    public static function create(): self
    {
        $app = new self();

        $app->registerRoutes();

        return $app;
    }

    private function registerRoutes(): void
    {
        $this->router = new Router($this);
    }

    public function handle(Request $request): Response
    {
        $dispatcher = new Dispatcher($this->router->getData());

        try {
            $content = $dispatcher->dispatch($request->getRealMethod(), parse_url($request->getUri(), PHP_URL_PATH));
        } catch (Throwable $throwable) {
            return new Response(Whoops::render($throwable), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $content instanceof Response ? $content : new Response($content);
    }
}