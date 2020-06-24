<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\Contest\Contest;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestant;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Contestant implements ContestantInterface
{
    private UuidInterface $id;

    /** @var GenreStrength[] */
    private array $genderStrength;

    /** @var RoundContestant[] */
    private array $roundsContestant;

    private Contest $contest;

    public function __construct(Contest $contest)
    {
        $this->id      = Uuid::uuid4();
        $this->contest = $contest;
        $this->generateGenreStrength();
    }

    private function generateGenreStrength(): void
    {
        $genres = MusicGenre::getEnumerators();
        \shuffle($genres);
        $this->genderStrength = [];

        foreach ($genres as $genre) {
            $genreStrength          = new GenreStrength($genre);
            $this->genderStrength[] = $genreStrength->asArray();
        }
    }

    public function contest(): Contest
    {
        return $this->contest;
    }
}
