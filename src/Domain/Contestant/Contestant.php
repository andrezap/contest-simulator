<?php

declare(strict_types=1);

namespace App\Domain\Contestant;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Exception\NotFoundContestantGenreStrength;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestant;
use App\Util\SearchMultidimensionalArray;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Contestant implements ContestantInterface
{
    private UuidInterface $id;

    /** @var GenreStrength[] */
    private array $genreStrengths;

    /** @var Collection|RoundContestant[] */
    private Collection $roundsContestant;

    private ContestInterface $contest;

    public function __construct(ContestInterface $contest)
    {
        $this->id               = Uuid::uuid4();
        $this->contest          = $contest;
        $this->roundsContestant = new ArrayCollection();
        $this->generateGenreStrength();
    }

    private function generateGenreStrength(): void
    {
        $genres = MusicGenre::getEnumerators();
        \shuffle($genres);
        $this->genreStrengths = [];

        foreach ($genres as $genre) {
            $genreStrength          = new GenreStrength($genre);
            $this->genreStrengths[] = $genreStrength->asArray();
        }
    }

    public function genreStrengths(): array
    {
        return $this->genreStrengths;
    }

    public function genreStrength(MusicGenre $musicGenre): float
    {
        $contestantGenreStrengths = SearchMultidimensionalArray::searchKey(
            $this->genreStrengths,
            $musicGenre->value()
        );

        if ($contestantGenreStrengths === []) {
            throw new NotFoundContestantGenreStrength();
        }

        return $contestantGenreStrengths[$musicGenre->value()];
    }

    public function contest(): ContestInterface
    {
        return $this->contest;
    }
}
