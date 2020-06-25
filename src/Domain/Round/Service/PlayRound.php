<?php

declare(strict_types=1);

namespace App\Domain\Round\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\InvalidContestException;
use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Round\Repository\RoundRepositoryInterface;
use App\Domain\RoundContestant\RoundContestant;

class PlayRound
{
    private ContestRepositoryInterface $contestRepository;

    private RoundRepositoryInterface $roundRepository;

    public function __construct(
        ContestRepositoryInterface $contestRepository,
        RoundRepositoryInterface $roundRepository
    ) {
        $this->contestRepository = $contestRepository;
        $this->roundRepository   = $roundRepository;
    }

    public function execute(ContestInterface $contest): void
    {
        $nextRound = $this->roundRepository->nextRoundForContest($contest);

        if ($nextRound === null || $contest->isDone()) {
            throw new InvalidContestException();
        }

        foreach ($contest->getContestants() as $contestant) {
            $roundContestant = new RoundContestant($nextRound, $contestant);
            $roundContestant->calculateScore();
            $nextRound->addRoundsContestant($roundContestant);
        }

        if ($nextRound->number() === ContestInterface::MAX_NUMBER_ROUNDS) {
            $contest->finish();
        }

        $this->roundRepository->store($nextRound);
        $this->contestRepository->store($contest);
    }
}
