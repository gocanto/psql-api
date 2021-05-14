<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Gocanto\PSQL\Application;
use Gocanto\PSQL\Env;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;

$app = new Application(new Env(), new Container());
$app->boot();

try {
    $app->handle(
        ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES)
    );
} catch (Throwable $throwable) {
    $app->terminate($throwable);
}
