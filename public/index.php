<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Gocanto\PSQL\Application;
use Symfony\Component\HttpFoundation\Request;

$application = Application::create();

$response = $application->handle(
    Request::createFromGlobals()
);

$response->send();