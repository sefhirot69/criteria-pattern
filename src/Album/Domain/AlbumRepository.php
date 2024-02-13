<?php

declare(strict_types=1);

namespace App\Album\Domain;

interface AlbumRepository
{
    public function save(Album $album): void;

    public function findById(int $id): ?Album;
}
