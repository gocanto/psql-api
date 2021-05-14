<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Exception\DomainException;
use Gocanto\PSQL\Repository\CarsRepository;
use JsonException;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UpdateController
{
    private CarsRepository $cars;

    public function __construct(CarsRepository $cars)
    {
        $this->cars = $cars;
    }

    /**
     * @param ServerRequest $request
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');

        $car = $this->cars->findById($id);

        if ($car === null) {
            return new JsonResponse([
                'error' => 'Not Found',
                'message' => "The given car id [$id] is invalid.",
            ], 404);
        }

        try {
            $data = $this->parse($request->getBody()->getContents());
        } catch (DomainException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
                'message' => 'The given data is invalid.',
            ], 403);
        }

        $car = $this->cars->update((int) $request->getAttribute('id'), $data);

        return new JsonResponse([
            'message' => "The given car [$id] was updated successfully.",
            'data' => $car->toArray(),
        ]);
    }

    /**
     * @throws DomainException
     */
    private function parse(string $body): array
    {
        if ($body === '') {
            return [];
        }

        try {
            $data = \json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw DomainException::fromThrowable($e);
        }

        return $this->sanitize(
            \is_array($data) ? $data : [$data]
        );
    }

    /**
     * @throws DomainException
     */
    private function sanitize(array $attributes): array
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
