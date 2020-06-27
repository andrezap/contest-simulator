<?php

declare(strict_types=1);

namespace App\Domain\Judge\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Judge\JudgeFactory;
use App\Domain\Judge\JudgeType;
use App\Domain\RoundContestant\RoundContestantInterface;

final class JudgeContestantRound
{
    public function execute(ContestInterface $contest, RoundContestantInterface $roundContestant): void
    {
        $judgeScore = 0;

        foreach ($contest->judges() as $judge) {
            $judge       = JudgeFactory::build(JudgeType::byValue($judge));
            $judgeScore += $judge->calculateScore($roundContestant);
        }

        $roundContestant->setFinalScore($judgeScore);
    }
}
