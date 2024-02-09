<?php

declare(strict_types=1);

namespace App\Album\Domain;

final class Album
{
    private function __construct(
        private readonly int $id,
        private readonly Title $title,
        private readonly Artist $artist,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }
}
