<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\RoundContestant\RoundContestantInterface;

final class FriendlyJudge implements JudgeInterface
{
    private const NAME = 'Friendly Judge';

    public function calculateScore(RoundContestantInterface $roundContestant): int
    {
        $score            = $roundContestant->score();
        $contestantIsSick = $roundContestant->isSick();
        $finalScore       = null;

        if ($score <= 3) {
            $finalScore = 7;
        } else {
            $finalScore = 8;
        }

        if ($contestantIsSick === true) {
            ++$finalScore;
        }

        return $finalScore;
    }

    public function name(): string
    {
        return self::NAME;
    }
}
