<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Repository\CarsRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

final class IndexController
{
    private CarsRepository $cars;

    public function __construct(CarsRepository $cars)
    {
        $this->cars = $cars;
    }

    public function __invoke(): ResponseInterface
    {
        $cars = $this->cars->getAll();

        return new JsonResponse([
            'total' => $cars->count(),
            'data' => $cars->toArray(),
        ]);
    }
}
