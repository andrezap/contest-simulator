<?php

declare(strict_types=1);

namespace App\Domain\Contestant\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\ContestantInterface;

interface ContestantRepositoryInterface
{
    public function findHighestScoreForContest(ContestInterface $contest): ContestantInterface;

    public function store(ContestantInterface $contestant): void;

    public function findLastFiveWinners(): array;

    public function findHighestScoreForAllContests(): ?array;
}
