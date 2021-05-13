<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http;

use Illuminate\Container\Container;
use Phroute\Phroute\HandlerResolverInterface;

class RouterResolver implements HandlerResolverInterface
{
    public function __construct(private Container $container)
    {
    }

    public function resolve($handler): mixed
    {
        if (is_array($handler) && is_string($handler[0])) {
            $handler[0] = $this->container[$handler[0]];
        }

        return $handler;
    }
}