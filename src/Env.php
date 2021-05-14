<?php

declare(strict_types=1);

namespace Gocanto\PSQL;

use Closure;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Dotenv\Repository\RepositoryInterface;
use PhpOption\Option;

final class Env
{
    private ?RepositoryInterface $repository = null;

    public function getRepository(): RepositoryInterface
    {
        if ($this->repository !== null) {
            return $this->repository;
        }

        $builder = RepositoryBuilder::createWithDefaultAdapters();
        $builder = $builder->addAdapter(PutenvAdapter::class);

        $this->repository = $builder->immutable()->make();

        return $this->repository;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Option::fromValue($this->getRepository()->get($key))
            ->map(function (mixed $value) {
                switch (\mb_strtolower($value)) {
                    case 'true':
                    case '(true)':
                        return true;
                    case 'false':
                    case '(false)':
                        return false;
                    case 'empty':
                    case '(empty)':
                        return '';
                    case 'null':
                    case '(null)':
                        return null;
                }

                if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                    return $matches[2];
                }

                return $value;
            })
            ->getOrCall(function () use ($default) {
                return $this->value($default);
            });
    }

    private function value($value, ...$args): mixed
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}