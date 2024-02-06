<?php

declare(strict_types=1);

namespace App\Album\Infrastructure\Api;

use App\Shared\Api\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetAlbumsController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse($request->query->all(), Response::HTTP_OK);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
