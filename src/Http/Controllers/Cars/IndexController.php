<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Repository\CarsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class IndexController
{
    public function __construct(private CarsRepository $cars)
    {
    }

    public function handle(): JsonResponse
    {
        return new JsonResponse($this->cars->all());
    }
}