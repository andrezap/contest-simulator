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

    private float $finalScore;

    public function __construct(RoundInterface $round, ContestantInterface $contestant)
    {
        $this->id         = Uuid::uuid4();
        $this->round      = $round;
        $this->contestant = $contestant;
    }

    public function calculateScore(): void
    {
        $index = \random_int(
            (int) RoundInterface::SCORE_INDEX_MIN * 10,
            RoundInterface::SCORE_INDEX_MAX * 10
        ) / 10;

        $genreStrength = $this->contestant->genreStrength($this->round->musicGenre());

        $this->score = $index * $genreStrength;
    }
}
