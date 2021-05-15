<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Tests;

use Illuminate\Support\Collection;
use Throwable;

final class Utils
{
    public static function parseResponse(string $response): Collection
    {
        try {
            return new Collection(\json_decode($response, true, 512, JSON_THROW_ON_ERROR));
        } catch (Throwable) {
            return new Collection();
        }
    }
}
