<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\RoundContestant\RoundContestantInterface;

interface JudgeInterface
{
    public function calculateScore(RoundContestantInterface $roundContestant): int;

    public function name(): string;
}
