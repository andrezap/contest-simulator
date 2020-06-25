<?php

declare(strict_types=1);

namespace App\Domain\Round\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Round\Round;
use App\Domain\Round\RoundInterface;

interface RoundRepositoryInterface
{
    public function nextRoundForContest(ContestInterface $contest): ?Round;

    public function store(RoundInterface $round): void;
}
