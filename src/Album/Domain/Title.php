<?php

declare(strict_types=1);

namespace App\Album\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

final class Title extends StringValueObject
{
    public static function fromString(string $value): self
    {
        return new self($value);
    }
}
