<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Exception\DomainException;
use Gocanto\PSQL\Repository\CarsRepository;
use Gocanto\PSQL\Repository\Sanitize;
use Illuminate\Support\Collection;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class StoreController
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
        try {
            $data = $this->validated(
                Sanitize::parse($request->getBody()->getContents())
            );
        } catch (DomainException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
                'message' => 'The given data is invalid.',
            ], 403);
        }

        return new JsonResponse([
            'message' => 'The given car was created successfully.',
            'data' => $this->cars->create($data)->toArray(),
        ]);
    }

    /**
     * @throws DomainException
     */
    private function validated(array $attributes): array
    {
        $required = ['model_name', 'model_type', 'model_brand', 'model_year'];

        $data = Collection::make($attributes)->pluck('field')->diff($required);

        if ($data->isNotEmpty()) {
            throw new DomainException('The given data is invalid.');
        }

        return $attributes;
    }
}
