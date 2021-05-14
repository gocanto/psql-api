<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Entity;

use Carbon\CarbonImmutable;

final class Car
{
    private int $id;
    private string $model;
    private string $type;
    private string $brand;
    private string $year;
    private CarbonImmutable $createdAt;
    private CarbonImmutable $updatedAt;

    public function __construct(array $attributes)
    {
        $this->setId($attributes['id']);
        $this->setModel($attributes['model']);
        $this->setType($attributes['type']);
        $this->setBrand($attributes['brand']);
        $this->setYear($attributes['year']);
        $this->setCreatedAt($attributes['created_at']);
        $this->setUpdatedAt($attributes['updated_at']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    private function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    private function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function getType(): string
    {
        return $this->type;
    }

    private function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    private function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    private function setYear(string $year): void
    {
        $this->year = $year;
    }

    public function getCreatedAt(): CarbonImmutable
    {
        return $this->createdAt;
    }

    private function setCreatedAt(CarbonImmutable | string $createdAt): void
    {
        $this->createdAt = CarbonImmutable::parse($createdAt);
    }

    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->updatedAt;
    }

    private function setUpdatedAt(CarbonImmutable | string $updatedAt): void
    {
        $this->updatedAt = CarbonImmutable::parse($updatedAt);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'model' => $this->getModel(),
            'type' => $this->getType(),
            'brand' => $this->getBrand(),
            'year' => $this->getYear(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }
}
