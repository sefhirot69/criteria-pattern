<?php

declare(strict_types=1);

namespace App\Tests\Unit\Album\Domain;

use App\Album\Domain\Title;

final class TitleMother
{
    public static function create(
        string $value = null
    ): Title {
        return Title::fromString(
            $value ?? 'The Dark Side of the Moon'
        );
    }
}
