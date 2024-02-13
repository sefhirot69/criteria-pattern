<?php

declare(strict_types=1);

namespace App\Tests\Integration\Album\Persistence\Repository;

use App\Album\Infrastructure\Persistence\Repository\DoctrineAlbumRepository;
use App\Tests\Unit\Album\Domain\AlbumMother;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineAlbumRepositoryTest extends KernelTestCase
{
    private DoctrineAlbumRepository $albumRepository;

    public function setUp(): void
    {
        self::bootKernel();
        $this->albumRepository = self::getContainer()->get(DoctrineAlbumRepository::class);
    }

    /** @test  */
    public function itShouldSaveAlbum(): void
    {
        $album = AlbumMother::create();

        $this->albumRepository->save($album);

        self::assertSame(
            $album,
            $this->albumRepository->findById($album->getId())
        );
    }
}
