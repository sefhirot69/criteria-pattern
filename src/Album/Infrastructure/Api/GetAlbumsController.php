<?php

declare(strict_types=1);

namespace App\Album\Infrastructure\Api;

use App\Shared\Api\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class GetAlbumsController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['ok'], JsonResponse::HTTP_OK);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
