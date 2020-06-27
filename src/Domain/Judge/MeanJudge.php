<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\RoundContestant\RoundContestantInterface;

final class MeanJudge implements JudgeInterface
{
    private const NAME = 'Mean Judge';

    public function calculateScore(RoundContestantInterface $roundContestant): int
    {
        $contestantScore = $roundContestant->score();

        if ($contestantScore < 90) {
            return 2;
        }

        return 10;
    }

    public function name(): string
    {
        return self::NAME;
    }
}
