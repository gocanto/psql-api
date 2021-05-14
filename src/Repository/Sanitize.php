<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Repository;

use Gocanto\PSQL\Exception\DomainException;
use JsonException;

class Sanitize
{
    /**
     * @throws DomainException
     */
    public static function parse(string $body): array
    {
        if ($body === '') {
            return [];
        }

        try {
            $data = \json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw DomainException::fromThrowable($e);
        }

        return self::sanitize(
            \is_array($data) ? $data : [$data]
        );
    }

    /**
     * @throws DomainException
     */
    private static function sanitize(array $attributes): array
    {
        $allowed = [
            'model' => 'model_name',
            'type' => 'model_type',
            'brand' => 'model_brand',
            'year' => 'model_year',
            'created_at' => 'model_date_added',
            'updated_at' => 'model_date_modified',
        ];

        $data = [];
        foreach ($allowed as $field => $dbField) {
            if (!empty($attributes[$field])) {
                $data[] = [
                    'value' => $attributes[$field],
                    'field' => $dbField,
                ];
            }
        }

        if (\count($data) === 0) {
            throw new DomainException('The given data did not match our records.');
        }

        return $data;
    }
}
