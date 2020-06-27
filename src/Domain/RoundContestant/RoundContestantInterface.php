<?php

declare(strict_types=1);

namespace App\Domain\RoundContestant;

use App\Domain\Round\RoundInterface;

interface RoundContestantInterface
{
    public function calculateScore(): void;

    public function round(): RoundInterface;

    public function score(): float;

    public function setFinalScore(int $finalScore): void;

    public function isSick(): bool;
}
