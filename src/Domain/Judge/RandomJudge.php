<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\RoundContestant\RoundContestantInterface;

final class RandomJudge implements JudgeInterface
{
    private const NAME = 'Random Judge';

    public function calculateScore(RoundContestantInterface $roundContestant) : int
    {
        return random_int(0, 10);
    }

    public function name() : string
    {
        return self::NAME;
    }
}