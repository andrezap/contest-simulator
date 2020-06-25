<?php

declare(strict_types=1);

namespace App\Domain\Judge\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Judge\JudgeFactory;
use App\Domain\Judge\JudgeType;

class JudgeGenerator
{
    public function generateForContest(ContestInterface $contest) : void
    {
        $judgesType = JudgeType::getEnumerators();

        shuffle($judgesType);

        for ($i = 0; $i < ContestInterface::MAX_NUMBER_JUDGES; $i++) {
            $judge = JudgeFactory::build($judgesType[$i]);
            $contest->addJudge($judge);
        }
    }
}