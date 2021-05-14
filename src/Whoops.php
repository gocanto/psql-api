<?php

declare(strict_types=1);

namespace Gocanto\PSQL;

use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

final class Whoops
{
    public static function render(Throwable $throwable): string
    {
        $whoops = new Run();

        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new PrettyPageHandler());

        return $whoops->handleException($throwable);
    }
}
