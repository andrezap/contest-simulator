<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\MusicGenre\MusicGenre;

interface ContestantInterface
{
    public function genreStrengths(): array;

    public function genreStrength(MusicGenre $musicGenre): float;
}
