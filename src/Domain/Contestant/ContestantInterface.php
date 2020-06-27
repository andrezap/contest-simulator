<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\Contest\ContestInterface;
use App\Domain\MusicGenre\MusicGenre;

interface ContestantInterface
{
    public const PERCENTAGE_CHANCE_TO_BECOME_SICK = 5;

    public function id(): string;

    public function name(): string;

    public function genreStrengths(): array;

    public function genreStrength(MusicGenre $musicGenre): float;

    public function markAsWinner(): void;

    public function contest(): ContestInterface;
}
