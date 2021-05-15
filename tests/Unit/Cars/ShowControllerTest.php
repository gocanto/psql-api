<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Tests\Unit\Cars;

use Carbon\CarbonImmutable;
use Gocanto\PSQL\Http\Controllers\Cars\ShowController;
use Gocanto\PSQL\Repository\CarsRepository;
use Gocanto\PSQL\Tests\Mock;
use Gocanto\PSQL\Tests\Utils;
use Laminas\Diactoros\Response\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @property CarbonImmutable now
 * @property CarsRepository|Mockery\LegacyMockInterface|Mockery\MockInterface repository
 * @property Mockery\LegacyMockInterface|Mockery\MockInterface|ServerRequestInterface request
 */
class ShowControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->now = CarbonImmutable::now();
        $this->repository = Mock::carsRepository();

        $this->request = Mockery::mock(ServerRequestInterface::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        CarbonImmutable::setTestNow();
    }

    /**
     * @test
     */
    public function itReturnsNotFoundOnInvalidCars(): void
    {
        $this->request->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);
        $this->repository->shouldReceive('findById')->once()->with(1)->andReturn(null);

        $response = $this->resolveResponse();
        $data = Utils::parseResponse($response->getBody()->getContents());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(404, $response->getStatusCode());
        self::assertNotNull($data->get('error'));
        self::assertNotNull($data->get('message'));
    }

    /**
     * @test
     */
    public function itProperlyShowsValidCars(): void
    {
        $car = Mock::car($this->now);

        $this->request->shouldReceive('getAttribute')->once()->with('id')->andReturn(1);
        $this->repository->shouldReceive('findById')->once()->with(1)->andReturn($car);

        $response = $this->resolveResponse();
        $data = Utils::parseResponse($response->getBody()->getContents());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame($data->get('data'), $car->toArray());
    }

    /**
     * @return JsonResponse
     */
    private function resolveResponse(): ResponseInterface
    {
        $controller = new ShowController($this->repository);

        return $controller($this->request);
    }
}
