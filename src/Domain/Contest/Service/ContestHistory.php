<?php

declare(strict_types=1);

namespace App\Domain\Contest\Service;

use App\Domain\Contestant\Repository\ContestantRepositoryInterface;

final class ContestHistory
{
    private ContestantRepositoryInterface $contestantRepository;

    public function __construct(ContestantRepositoryInterface $contestantRepository)
    {
        $this->contestantRepository = $contestantRepository;
    }

    public function execute(): array
    {
        $winners      = $this->contestantRepository->findLastFiveWinners();
        $highestScore = $this->contestantRepository->findHighestScoreForAllContests();

        return [
            'winners' => $winners,
            'highestScore' => $highestScore,
        ];
    }
}
