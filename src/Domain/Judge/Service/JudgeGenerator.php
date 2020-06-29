<?php

declare(strict_types=1);

namespace App\Domain\Judge\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Judge\JudgeType;

final class JudgeGenerator
{
    public function generateForContest(ContestInterface $contest): void
    {
        $judgesType = JudgeType::getValues();

        \shuffle($judgesType);

        $judges = [];

        for ($i = 0; $i < ContestInterface::MAX_NUMBER_JUDGES; $i++) {
            $judges[] = $judgesType[$i];
        }

        $contest->addJudges($judges);
    }
}
