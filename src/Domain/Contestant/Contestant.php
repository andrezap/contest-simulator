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

    private string $name;

    /** @var GenreStrength[] */
    private array $genreStrengths;

    /** @var Collection|RoundContestant[] */
    private Collection $roundsContestant;

    private ContestInterface $contest;

    private bool $winner;

    public function __construct(string $name, array $genreStrength, ContestInterface $contest)
    {
        $this->id               = Uuid::uuid4();
        $this->winner           = false;
        $this->contest          = $contest;
        $this->genreStrengths   = $genreStrength;
        $this->name             = $name;
        $this->roundsContestant = new ArrayCollection();
    }

    public function id(): string
    {
        return $this->id->toString();
    }

    public function name(): string
    {
        return $this->name;
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

    public function markAsWinner(): void
    {
        $this->winner = true;
    }
}
