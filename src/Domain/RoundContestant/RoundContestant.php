<?php

declare(strict_types=1);

namespace App\Domain\RoundContestant;

use App\Domain\Contestant\ContestantInterface;
use App\Domain\Round\RoundInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class RoundContestant implements RoundContestantInterface
{
    private UuidInterface $id;

    private RoundInterface $round;

    private ContestantInterface $contestant;

    private float $score;

    private int $finalScore;

    private bool $sick;

    private function __construct(RoundInterface $round, ContestantInterface $contestant)
    {
        $this->id         = Uuid::uuid4();
        $this->round      = $round;
        $this->contestant = $contestant;
        $this->sick       = \random_int(0, 99) < ContestantInterface::PERCENTAGE_CHANCE_TO_BECOME_SICK;
    }

    public static function createRoundForContestant(RoundInterface $round, ContestantInterface $contestant): self
    {
        $roundContestant = new self($round, $contestant);
        $roundContestant->calculateScore();
        $round->addRoundContestant($roundContestant);

        return $roundContestant;
    }

    public function calculateScore(): void
    {
        $index = \random_int(
            (int) RoundInterface::SCORE_INDEX_MIN * 10,
            RoundInterface::SCORE_INDEX_MAX * 10
        ) / 10;

        $genreStrength = $this->contestant->genreStrength($this->round->musicGenre());

        $score = $index * $genreStrength;

        if ($this->isSick()) {
            $score /= 2;
        }

        $this->score = \round($score, 1);
    }

    public function isSick(): bool
    {
        return $this->sick;
    }

    public function round(): RoundInterface
    {
        return $this->round;
    }

    public function score(): float
    {
        return $this->score;
    }

    public function setFinalScore(int $finalScore): void
    {
        $this->finalScore = $finalScore;
    }
}
