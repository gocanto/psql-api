<?php

declare(strict_types=1);

namespace Gocanto\PSQL\Http\Controllers\Cars;

use Gocanto\PSQL\Repository\CarsRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteController
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

        $this->cars->delete($car);

        return new JsonResponse([
            'message' => "The given car [$id] was deleted successfully.",
        ]);
    }
}
