<?php

declare(strict_types=1);

namespace App\Domain\Round\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\InvalidContestException;
use App\Domain\Judge\Service\JudgeContestantRound;
use App\Domain\Round\Repository\RoundRepositoryInterface;
use App\Domain\Round\RoundInterface;
use App\Domain\RoundContestant\RoundContestant;

final class PlayRound
{
    private RoundRepositoryInterface $roundRepository;

    private JudgeContestantRound $judgeContestantRound;

    public function __construct(
        RoundRepositoryInterface $roundRepository,
        JudgeContestantRound $judgeContestantRound
    ) {
        $this->roundRepository      = $roundRepository;
        $this->judgeContestantRound = $judgeContestantRound;
    }

    public function execute(ContestInterface $contest): RoundInterface
    {
        $round = $this->roundRepository->nextRoundForContest($contest);

        if ($round === null || $contest->isDone()) {
            throw new InvalidContestException();
        }

        foreach ($contest->contestants() as $contestant) {
            $roundContestant = RoundContestant::createRoundForContestant($round, $contestant);

            $this->judgeContestantRound->execute($contest, $roundContestant);
        }

        $round->finish();

        $this->roundRepository->store($round);

        return $round;
    }
}
