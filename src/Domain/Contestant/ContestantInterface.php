<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\Contest\ContestInterface;
use App\Domain\MusicGenre\MusicGenre;

interface ContestantInterface
{
    public static function createForContest(ContestInterface $contest) : self;

    public function id() : string;

    public function genreStrengths() : array;

    public function genreStrength(MusicGenre $musicGenre) : float;

    public function markAsWinner() : void;

    public function contest() : ContestInterface;
}
