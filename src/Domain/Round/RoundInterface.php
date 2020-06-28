<?php

declare(strict_types=1);

namespace App\Domain\Round;

use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestantInterface;
use Ramsey\Uuid\UuidInterface;

interface RoundInterface
{
    public const SCORE_INDEX_MIN = 0.1;
    public const SCORE_INDEX_MAX = 10;

    public function id(): UuidInterface;

    /**
     * @internal Used only for test purpose
     */
    public function setIdFromString(string $id): void;

    public function musicGenre(): MusicGenre;

    public function number(): int;

    public function setNumber(int $number): void;

    public function addRoundContestant(RoundContestantInterface $roundContestant): void;

    public function finish(): void;

    public function isLastRound(): bool;
}
