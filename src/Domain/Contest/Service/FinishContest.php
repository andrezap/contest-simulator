<?php

declare(strict_types=1);

namespace App\Domain\Contest\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Contestant\ContestantInterface;
use App\Domain\Contestant\Repository\ContestantRepositoryInterface;

final class FinishContest
{
    private ContestantRepositoryInterface $contestantRepository;

    private ContestRepositoryInterface $contestRepository;

    public function __construct(
        ContestRepositoryInterface $contestRepository,
        ContestantRepositoryInterface $contestantRepository
    ) {
        $this->contestantRepository = $contestantRepository;
        $this->contestRepository    = $contestRepository;
    }

    public function execute(ContestInterface $contest): ContestantInterface
    {
        $contest->finish();

        $contestant = $this->contestantRepository->findHighestScoreForContest($contest);
        $contestant->markAsWinner();

        $this->contestantRepository->store($contestant);
        $this->contestRepository->store($contest);

        return $contestant;
    }
}
