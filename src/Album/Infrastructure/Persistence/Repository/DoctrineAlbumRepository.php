<?php

declare(strict_types=1);

namespace App\Album\Infrastructure\Persistence\Repository;

use App\Album\Domain\Album;
use App\Album\Domain\AlbumRepository;
use App\Shared\Infrastructure\Persistence\Repository\DoctrineRepository;

class DoctrineAlbumRepository extends DoctrineRepository implements AlbumRepository
{
    public function save(Album $album): void
    {
        $this->persist($album);
    }

    public function findById(int $id): ?Album
    {
        $album = $this->repository(Album::class)->find($id);

        return $album instanceof Album ? $album : null;
    }
}
