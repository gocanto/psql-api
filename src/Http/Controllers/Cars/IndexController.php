<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Repository\CarsRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class IndexController
{
    public function __construct(private CarsRepository $cars)
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'cars' => $this->cars->all(),
            'request' => $request->getQueryParams(),
        ]);
    }
}