<?php

declare(strict_types=1);

namespace App\Domain\Round;

use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestantInterface;

interface RoundInterface
{
    public const SCORE_INDEX_MIN = 0.1;
    public const SCORE_INDEX_MAX = 10;

    public function musicGenre(): MusicGenre;

    public function number(): int;

    public function addRoundContestant(RoundContestantInterface $roundContestant): void;

    public function finish(): void;

    public function isLastRound(): bool;
}
