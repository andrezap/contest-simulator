<?php

declare(strict_types=1);

namespace App\Domain\Judge\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Judge\JudgeType;

class JudgeGenerator
{
    public function generateForContest(ContestInterface $contest) : void
    {
        $judgesType = JudgeType::getEnumerators();

        shuffle($judgesType);

        $judges = [];

        for ($i = 0; $i < ContestInterface::MAX_NUMBER_JUDGES; $i++) {
            $judges[] = $judgesType[$i]->value();
        }

        $contest->addJudges($judges);
    }
}