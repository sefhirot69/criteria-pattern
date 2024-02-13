<?php

declare(strict_types=1);

namespace App\Album\Domain;

final class Album
{
    private function __construct(
        private readonly Title $title,
        private readonly Artist $artist,
        private readonly ?int $id = null,
    ) {
    }

    public static function create(Title $title, Artist $artist): self
    {
        return new self($title, $artist);
    }

    public function getId(): ?int
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
