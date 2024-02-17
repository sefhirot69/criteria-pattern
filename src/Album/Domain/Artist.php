<?php

declare(strict_types=1);

namespace App\Album\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Artist
{
    private function __construct(
        private readonly UuidInterface $id,
        private readonly Name $name,
    ) {
    }

    public static function create(Name $name): self
    {
        return new self(
            Uuid::uuid7(),
            $name,
        );
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
