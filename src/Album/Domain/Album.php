<?php

declare(strict_types=1);

namespace App\Album\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Album extends AggregateRoot
{
    private function __construct(
        private readonly UuidInterface $id,
        private readonly Title $title,
        private readonly Artist $artist,
    ) {
    }

    public static function create(Title $title, Artist $artist): self
    {
        return new self(
            Uuid::uuid7(),
            $title,
            $artist
        );
    }

    public function getId(): UuidInterface
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
