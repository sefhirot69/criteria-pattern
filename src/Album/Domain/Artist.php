<?php

declare(strict_types=1);

namespace App\Album\Domain;

final class Artist
{
    private function __construct(
        private int $id,
        private Name $name,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
