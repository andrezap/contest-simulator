<?php

declare(strict_types=1);

namespace App\Domain\Round\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\InvalidContestException;
use App\Domain\Contest\Service\FinishContest;
use App\Domain\Judge\Service\JudgeContestantRound;
use App\Domain\Round\Repository\RoundRepositoryInterface;
use App\Domain\RoundContestant\RoundContestant;

final class PlayRound
{
    private RoundRepositoryInterface $roundRepository;

    private FinishContest $finishContest;

    private JudgeContestantRound $judgeContestantRound;

    public function __construct(
        RoundRepositoryInterface $roundRepository,
        FinishContest $finishContest,
        JudgeContestantRound $judgeContestantRound
    ) {
        $this->roundRepository      = $roundRepository;
        $this->finishContest        = $finishContest;
        $this->judgeContestantRound = $judgeContestantRound;
    }

    public function execute(ContestInterface $contest) : void
    {
        $round = $this->roundRepository->nextRoundForContest($contest);

        if ($round === null || $contest->isDone()) {
            throw new InvalidContestException();
        }

        foreach ($contest->getContestants() as $contestant) {
            $roundContestant = RoundContestant::createRoundForContestant($round, $contestant);

            $this->judgeContestantRound->execute($contest, $roundContestant);
        }

        $round->finish();

        if ($round->isLastRound()) {
            $this->finishContest->execute($contest);
        }

        $this->roundRepository->store($round);
    }
}
