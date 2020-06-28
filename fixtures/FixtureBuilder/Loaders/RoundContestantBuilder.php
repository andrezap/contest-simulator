<?php

declare(strict_types=1);

namespace App\FixtureBuilder\Loaders;

use App\Domain\Contestant\ContestantInterface;
use App\Domain\Round\RoundInterface;
use App\Domain\RoundContestant\RoundContestant;
use App\Domain\RoundContestant\RoundContestantInterface;

final class RoundContestantBuilder
{
    private const DEFAULT_SCORE = 10;

    private RoundContestantInterface $roundContestant;

    private function __construct(RoundInterface $round, ContestantInterface $contestant)
    {
        $this->roundContestant = new RoundContestant($round, $contestant);
        $this->roundContestant->setScore(self::DEFAULT_SCORE);
    }

    public static function create(RoundInterface $round, ContestantInterface $contestant) : self
    {
        return new self($round, $contestant);
    }

    public function withFinalScore(int $finalScore) : self
    {
        $this->roundContestant->setFinalScore($finalScore);

        return $this;
    }

    public function build() : RoundContestantInterface
    {
        return $this->roundContestant;
    }
}