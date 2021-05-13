<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Provider;

interface ProviderInterface
{
    public function register(): void;
}