<?php

declare(strict_types=1);

namespace App\Domain\Contest\Service;

use App\Domain\Contest\Contest;
use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\RunningContestException;
use App\Domain\Contest\Repository\ContestRepositoryInterface;
use App\Domain\Contestant\Service\ContestantGenerator;
use App\Domain\Judge\Service\JudgeGenerator;
use App\Domain\Round\Service\RoundGenerator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateNewContest
{
    private ValidatorInterface $validator;

    private ContestRepositoryInterface $contestRepository;

    private ContestantGenerator $contestantGenerator;

    private JudgeGenerator $judgeGenerator;

    private RoundGenerator $roundGenerator;

    public function __construct(
        ValidatorInterface $validator,
        ContestRepositoryInterface $contestRepository,
        ContestantGenerator $contestantGenerator,
        JudgeGenerator $judgeGenerator,
        RoundGenerator $roundGenerator
    ) {
        $this->validator           = $validator;
        $this->contestRepository   = $contestRepository;
        $this->contestantGenerator = $contestantGenerator;
        $this->judgeGenerator      = $judgeGenerator;
        $this->roundGenerator      = $roundGenerator;
    }

    public function execute() : ContestInterface
    {
        $contest = new Contest();
        $errors  = $this->validator->validate($contest);

        if (\count($errors) > 0) {
            throw new RunningContestException();
        }

        $this->roundGenerator->generateForContest($contest);
        $this->contestantGenerator->generateForContest($contest);
        $this->judgeGenerator->generateForContest($contest);

        $contest->start();

        $this->contestRepository->store($contest);

        return $contest;
    }
}
