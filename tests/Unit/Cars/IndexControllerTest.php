<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Tests\Unit\Cars;

use Carbon\CarbonImmutable;
use Gocanto\PSQL\Http\Controllers\Cars\IndexController;
use Gocanto\PSQL\Repository\CarsRepository;
use Gocanto\PSQL\Tests\Mock;
use Gocanto\PSQL\Tests\Utils;
use Laminas\Diactoros\Response\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * @property CarbonImmutable now
 * @property CarsRepository|Mockery\LegacyMockInterface|Mockery\MockInterface repository
 */
class IndexControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->now = CarbonImmutable::now();
        $this->repository = Mock::carsRepository();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        CarbonImmutable::setTestNow();
    }

    /**
     * @test
     */
    public function itProperlyRespondWithAllCars(): void
    {
        $cars = Mock::carsCollection($this->now);

        $this->repository->shouldReceive('getAll')->once()->andReturn($cars);

        $response = $this->resolveResponse();

        $content = Utils::parseResponse($response->getBody()->getContents());
        $data = $content->get('data');

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertSame(1, $content->get('total'));
        self::assertCount(1, $data);

        self::assertSame($cars->toArray(), $data);
    }

    /**
     * @return JsonResponse
     */
    private function resolveResponse(): ResponseInterface
    {
        $controller = new IndexController($this->repository);

        return $controller();
    }
}
