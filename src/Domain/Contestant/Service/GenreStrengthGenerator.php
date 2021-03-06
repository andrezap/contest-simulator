<?php

declare(strict_types=1);

namespace App\Domain\Contestant\Service;

use App\Domain\Contestant\GenreStrength;
use App\Domain\MusicGenre\MusicGenre;

final class GenreStrengthGenerator
{
    /**
     * @return mixed[]
     */
    public static function execute(): array
    {
        $genres = MusicGenre::getEnumerators();

        \shuffle($genres);

        $genresStrength = [];

        foreach ($genres as $genre) {
            $genreStrength    = new GenreStrength($genre);
            $genresStrength[] = $genreStrength->asArray();
        }

        return $genresStrength;
    }
}
