<?php

namespace App\Tests\Unit\Album\Domain;

use App\Album\Domain\Album;
use App\Album\Domain\Artist;
use App\Album\Domain\Title;

class AlbumMother
{
    public static function create(
        Title $title = null,
        Artist $artist = null
    ): Album {
        return Album::create(
            $title ?? TitleMother::create(),
            $artist ?? ArtistMother::create()
        );
    }
}
