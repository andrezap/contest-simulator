<?php

declare(strict_types=1);

namespace App\Domain\History\Service;

use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use App\Domain\History\History;

final class CreateHistory
{
    private ContestantRepositoryInterface $contestantRepository;

    public function __construct(ContestantRepositoryInterface $contestantRepository)
    {
        $this->contestantRepository = $contestantRepository;
    }

    /**
     * @return mixed[]
     */
    public function execute(): array
    {
        $winners   = $this->contestantRepository->findLastFiveWinners();
        $topWinner = $this->contestantRepository->findHighestScoreForAllContests();

        $history = new History($winners, $topWinner);

        return $history->toArray();
    }
}
