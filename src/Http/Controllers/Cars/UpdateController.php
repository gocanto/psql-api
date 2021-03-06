<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Exception\DomainException;
use Gocanto\PSQL\Repository\CarsRepository;
use Gocanto\PSQL\Repository\Sanitize;
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
            $data = Sanitize::parse($request->getBody()->getContents());
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
}
