<?php

declare(strict_types=1);

namespace App\Domain\RoundContestant;

use App\Domain\Contestant\ContestantInterface;
use App\Domain\Round\Round;
use Ramsey\Uuid\UuidInterface;

class RoundContestant
{
    private UuidInterface $id;

    private Round $round;

    private ContestantInterface $contestant;

    private float $score;
}
