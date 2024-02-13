<?php

declare(strict_types=1);

namespace App\Tests\Unit\Album\Domain;

use App\Album\Domain\Artist;
use App\Album\Domain\Name;

final class ArtistMother
{
    public static function create(
        Name $name = null
    ): Artist {
        return Artist::create(
            $name ?? NameMother::create()
        );
    }
}
