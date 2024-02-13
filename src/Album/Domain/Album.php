<?php

declare(strict_types=1);

namespace App\Album\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

final class Album extends AggregateRoot
{
    private function __construct(
        private readonly Title $title,
        private readonly Artist $artist,
        private readonly ?int $id = 9999,
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
