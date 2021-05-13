<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse('ok');
    }
}