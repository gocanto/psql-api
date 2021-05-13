<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Gocanto\PSQL\Application;
use Gocanto\PSQL\Whoops;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequestFactory;
use League\Container\Container;

$app = new Application(new Container());

try {
    $app->handle(
        ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES)
    );
} catch (Throwable $throwable) {
    $response = new HtmlResponse(Whoops::render($throwable), 200, [
        'Content-Type' => ['application/xhtml+xml']
    ]);

    echo $response->getBody()->getContents();
}