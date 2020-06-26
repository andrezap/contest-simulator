<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestantInterface;

final class RockJudge implements JudgeInterface
{
    private const NAME = 'Rock Judge';

    public function calculateScore(RoundContestantInterface $roundContestant) : int
    {
        if ($roundContestant->round()->musicGenre()->is(MusicGenre::ROCK)) {
            $contestScore = $roundContestant->score();

            if ($contestScore < 50) {
                return 5;
            }

            if ($contestScore >= 50 && $contestScore <= 74.9) {
                return 8;
            }

            if ($contestScore >= 75) {
                return 10;
            }
        }

        return random_int(0, 10);
    }

    public function name() : string
    {
        return self::NAME;
    }
}