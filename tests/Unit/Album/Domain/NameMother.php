<?php

declare(strict_types=1);

namespace App\Tests\Unit\Album\Domain;

use App\Album\Domain\Name;

final class NameMother
{
    public static function create(
        string $value = null
    ): Name {
        return Name::fromString(
            $value ?? 'Pepe fitipaldi'
        );
    }
}
