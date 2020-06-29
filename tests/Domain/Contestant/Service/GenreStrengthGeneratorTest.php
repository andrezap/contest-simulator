<?php

declare(strict_types=1);

namespace App\Tests\Domain\Contestant\Service;

use App\Domain\Contestant\Service\GenreStrengthGenerator;
use App\Domain\MusicGenre\MusicGenre;
use App\Util\SearchMultidimensionalArray;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class GenreStrengthGeneratorTest extends WebTestCase
{
    public function testGenreStrengthGenerator(): void
    {
        $genreStrengthGenerator = GenreStrengthGenerator::execute();

        self::assertCount(6, $genreStrengthGenerator);

        foreach (MusicGenre::getValues() as $genre) {
            $key = SearchMultidimensionalArray::searchKey($genreStrengthGenerator, $genre);
            self::assertNotEmpty($key);
        }
    }
}
