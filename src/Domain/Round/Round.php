<?php

declare(strict_types=1);

namespace App\Domain\Round;

use App\Domain\Contest\ContestInterface;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\RoundContestant\RoundContestant;
use App\Domain\RoundContestant\RoundContestantInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Round implements RoundInterface
{
    private UuidInterface $id;

    private bool $finished;

    private int $number;

    private string $musicGenre;

    private ContestInterface $contest;

    /** @var Collection|RoundContestant[] */
    private Collection $roundsContestant;

    public function __construct(ContestInterface $contest, MusicGenre $musicGenre, int $number)
    {
        $this->id               = Uuid::uuid4();
        $this->finished         = false;
        $this->roundsContestant = new ArrayCollection();
        $this->number           = $number;
        $this->musicGenre       = $musicGenre->value();
        $this->contest          = $contest;
    }

    public function contest(): ContestInterface
    {
        return $this->contest;
    }

    public function musicGenre(): MusicGenre
    {
        return MusicGenre::byValue((string) $this->musicGenre);
    }

    public function number(): int
    {
        return $this->number;
    }

    public function addRoundContestant(RoundContestantInterface $roundContestant): void
    {
        $this->roundsContestant->add($roundContestant);
    }

    public function finish(): void
    {
        $this->finished = true;
    }

    public function isLastRound(): bool
    {
        return $this->number() === ContestInterface::MAX_NUMBER_ROUNDS;
    }
}
