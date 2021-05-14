<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Provider;

use Gocanto\PSQL\Env;
use League\Container\Container;

interface ProviderInterface
{
    public function setEnv(Env $env): void;
    public function setContainer(Container $container): void;

    public function register(): void;
}