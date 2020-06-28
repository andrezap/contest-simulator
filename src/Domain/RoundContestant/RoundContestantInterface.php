<?php

declare(strict_types=1);

namespace App\Domain\RoundContestant;

use App\Domain\Round\RoundInterface;
use Ramsey\Uuid\UuidInterface;

interface RoundContestantInterface
{
    public function calculateScore(): void;

    public function round(): RoundInterface;

    public function score(): float;

    public function setFinalScore(int $finalScore): void;

    public function isSick(): bool;

    public function id(): UuidInterface;

    public function finalScore(): int;

    public function setScore(float $score): void;
}
