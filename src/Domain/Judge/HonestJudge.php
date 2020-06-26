<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\RoundContestant\RoundContestantInterface;

class HonestJudge implements JudgeInterface
{
    private const NAME = 'Honest Judge';

    public function calculateScore(RoundContestantInterface $roundContestant) : int
    {
        $contestantScore = $roundContestant->score();

        if ($contestantScore <= 10) {
            return 1;
        }

        if ($contestantScore >= 10.1 & $contestantScore < 20) {
            return 2;
        }

        if ($contestantScore >= 20.1 && $contestantScore < 30) {
            return 3;
        }

        if ($contestantScore >= 30.1 && $contestantScore < 40) {
            return 4;
        }

        if ($contestantScore >= 40.1 && $contestantScore < 50) {
            return 5;
        }

        if ($contestantScore >= 50.1 && $contestantScore < 60) {
            return 6;
        }

        if ($contestantScore >= 60.1 && $contestantScore < 70) {
            return 7;
        }

        if ($contestantScore >= 70.1 && $contestantScore < 80) {
            return 8;
        }

        if ($contestantScore >= 80.1 && $contestantScore < 90) {
            return 9;
        }

        return 10;
    }

    public function name() : string
    {
        return self::NAME;
    }
}