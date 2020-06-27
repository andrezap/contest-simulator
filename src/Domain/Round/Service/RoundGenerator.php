<?php

declare(strict_types=1);

namespace App\Domain\Round\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\Round\Round;

final class RoundGenerator
{
    public function generateForContest(ContestInterface $contest): void
    {
        $genders = MusicGenre::getEnumerators();

        \shuffle($genders);

        for ($i = 1; $i <= ContestInterface::MAX_NUMBER_ROUNDS; $i++) {
            $contest->addRound(new Round($contest, $genders[$i - 1], $i));
        }
    }
}
