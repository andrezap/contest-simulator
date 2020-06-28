<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\Contest\ContestInterface;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestant;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface ContestantInterface
{
    public const PERCENTAGE_CHANCE_TO_BECOME_SICK = 5;

    public function id(): UuidInterface;

    public function setName(string $name): void;

    /**
     * @internal Used only for test purpose
     */
    public function setIdFromString(string $id): void;

    public function name(): string;

    /**
     * @return Collection|RoundContestant[]
     */
    public function roundsContestant(): Collection;

    /**
     * @return GenreStrength[]
     */
    public function allGenreStrengths(): array;

    public function genreStrength(MusicGenre $musicGenre): float;

    public function markAsWinner(): void;

    public function contest(): ContestInterface;

    public function setContest(ContestInterface $contest): void;
}
