<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\RoundContestant\RoundContestantInterface;

final class FriendlyJudge implements JudgeInterface
{
    private const NAME = 'Friendly Judge';

    public function calculateScore(RoundContestantInterface $roundContestant): int
    {
        return 0;
    }

    public function name(): string
    {
        return self::NAME;
    }
}
