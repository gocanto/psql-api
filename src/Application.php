<?php

declare(strict_types=1);

namespace Gocanto\PSQL;

use Dotenv\Dotenv;
use Gocanto\PSQL\Exception\DomainException;
use Gocanto\PSQL\Http\Router;
use Gocanto\PSQL\Provider\AppServiceProvider;
use Gocanto\PSQL\Provider\ProviderInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use League\Container\Container;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;
use Throwable;

final class Application
{
    private Router $router;

    /** @var ProviderInterface[] */
    private array $providers = [
        AppServiceProvider::class,
    ];

    public function __construct(private Env $env, private Container $container)
    {
    }

    public function boot(): void
    {
        $this->loadEnv();
        $this->registerProviders();
        $this->registerRoutes();
    }

    /**
     * @throws NotFoundException
     */
    public function terminate(Throwable $throwable): void
    {
        if ($this->isProd()) {
            throw new NotFoundException('Not Found', DomainException::fromThrowable($throwable));
        }

        $response = new HtmlResponse(Whoops::render($throwable), 200, [
            'Content-Type' => ['application/xhtml+xml'],
        ]);

        echo $response->getBody()->getContents();
    }

    private function loadEnv(): void
    {
        Dotenv::create($this->env->getRepository(), __DIR__ . '/../')->safeLoad();
    }

    private function registerProviders(): void
    {
        /** @var ProviderInterface $abstract */
        foreach ($this->providers as $provider) {
            $abstract = new $provider();

            $abstract->setContainer($this->container);
            $abstract->setEnv($this->env);

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

    public function isProd(): bool
    {
        return $this->env->get('APP_ENV') === 'production';
    }
}
