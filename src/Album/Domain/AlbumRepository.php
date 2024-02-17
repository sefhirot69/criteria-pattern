<?php

declare(strict_types=1);

namespace App\Album\Domain;

use Ramsey\Uuid\UuidInterface;

interface AlbumRepository
{
    public function save(Album $album): void;

    public function findById(UuidInterface $id): ?Album;
}
