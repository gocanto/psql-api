<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Tests\Unit;

use Gocanto\PSQL\Http\Controllers\Cars\DeleteController;
use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Gocanto\PSQL\Http\Controllers\Cars\ShowController;
use Gocanto\PSQL\Http\Controllers\Cars\StoreController;
use Gocanto\PSQL\Http\Controllers\Cars\UpdateController;
use Gocanto\PSQL\Http\Router;
use Laminas\Diactoros\ServerRequest;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\RouteGroup;
use League\Route\Router as LeagueRouter;
use League\Route\Strategy\ApplicationStrategy;
use Mockery;
use Psr\Http\Message\ResponseInterface;

/**
 * @property LeagueRouter|Mockery\LegacyMockInterface|Mockery\MockInterface baseRouter
 * @property SapiEmitter|Mockery\LegacyMockInterface|Mockery\MockInterface sapiEmitter
 */
class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->baseRouter = Mockery::mock(LeagueRouter::class);
        $this->sapiEmitter = Mockery::mock(SapiEmitter::class);
    }

    /**
     * @test
     */
    public function itProperlyRoutesRequests(): void
    {
        $request = Mockery::mock(ServerRequest::class);

        $this->baseRouter->shouldReceive('dispatch')->once()->with($request);

        $this->sapiEmitter->shouldReceive('emit')->once()
            ->withArgs(static fn ($response): bool => $response instanceof ResponseInterface);

        $router = $this->getRouter();

        $router->dispatch($request);
    }

    private function getRouter(): Router
    {
        $strategy = Mockery::mock(ApplicationStrategy::class);

        $this->baseRouter->shouldReceive('setStrategy')->once()->with($strategy);

        $this->baseRouter->shouldReceive('group')
            ->once()
            ->withArgs(function (string $name, callable $group): bool {
                $group($this->getRouteGroupMock());

                return $name === 'api';
            });

        return new Router($this->baseRouter, $strategy, $this->sapiEmitter);
    }

    private function getRouteGroupMock(): Mockery\MockInterface | Mockery\LegacyMockInterface | RouteGroup
    {
        $group = Mockery::mock(RouteGroup::class);

        $group->shouldReceive('map')->with('POST', '/cars', StoreController::class)->once();
        $group->shouldReceive('map')->with('GET', '/cars', IndexController::class)->once();
        $group->shouldReceive('map')->with('GET', '/cars/{id:number}', ShowController::class)->once();
        $group->shouldReceive('map')->with('PUT', '/cars/{id:number}', UpdateController::class)->once();
        $group->shouldReceive('map')->with('DELETE', '/cars/{id:number}', DeleteController::class)->once();

        return $group;
    }
}
