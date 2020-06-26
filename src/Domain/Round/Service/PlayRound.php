<?php

declare(strict_types=1);

namespace App\Domain\Round\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\InvalidContestException;
use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Judge\JudgeFactory;
use App\Domain\Judge\JudgeType;
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

    public function execute(ContestInterface $contest) : void
    {
        $round = $this->roundRepository->nextRoundForContest($contest);

        if ($round === null || $contest->isDone()) {
            throw new InvalidContestException();
        }

        foreach ($contest->getContestants() as $contestant) {
            $roundContestant = new RoundContestant($round, $contestant);
            $roundContestant->calculateScore();
            $round->addRoundsContestant($roundContestant);

            $judgeScore = 0;
            foreach ($contest->getJudges() as $judge) {
                $judge      = JudgeFactory::build(JudgeType::byValue($judge));
                $judgeScore += $judge->calculateScore($roundContestant);
            }

            //missing sick round
            $roundContestant->setFinalScore($judgeScore);
        }

        $round->finish();

        if ($round->number() === ContestInterface::MAX_NUMBER_ROUNDS) {
            $contest->finish();
        }

        $this->roundRepository->store($round);
        $this->contestRepository->store($contest);
    }
}
