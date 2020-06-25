<?php

declare(strict_types=1);

namespace App\Domain\Contestant\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Contestant;

final class ContestantGenerator
{
    public function generateForContest(ContestInterface $contest): void
    {
        for ($i = 0; $i < $contest::MAX_NUMBER_CONTESTANTS; $i++) {
            $contestant = new Contestant($contest);
            $contest->addContestant($contestant);
        }
    }
}
