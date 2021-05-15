<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Tests\Unit;

use Carbon\CarbonImmutable;
use Mockery;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected CarbonImmutable $now;

    protected function setUp(): void
    {
        $this->now = CarbonImmutable::now();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        CarbonImmutable::setTestNow();
    }
}
