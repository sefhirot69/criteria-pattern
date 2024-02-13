<?php

declare(strict_types=1);

namespace App\Album\Domain;

final class Artist
{
    private function __construct(
        private readonly Name $name,
        private readonly ?int $id = null,
    ) {
    }

    public static function create(Name $name): self
    {
        return new self($name, null);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }
}
