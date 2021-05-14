<?php

declare(strict_types=1);

namespace Gocanto\PSQL\DB;

use Gocanto\PSQL\Env;

final class Config
{
    private string $host;
    private string $name;
    private string $user;
    private string $pass;
    private string $port;

    public function __construct(Env $env)
    {
        $this->host = $env->get('DB_HOST');
        $this->name = $env->get('DB_NAME');
        $this->user = $env->get('DB_USER');
        $this->pass = $env->get('DB_PASS');
        $this->port = $env->get('DB_PORT');
    }

    public function getHost(): mixed
    {
        return $this->host;
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function getUser(): mixed
    {
        return $this->user;
    }

    public function getPass(): mixed
    {
        return $this->pass;
    }

    public function getPort(): mixed
    {
        return $this->port;
    }

    public function getDns(): string
    {
        return "pgsql:host=$this->host;port=$this->port;dbname=$this->name;";
    }
}
