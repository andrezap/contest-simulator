<?php

declare(strict_types=1);

namespace App\Domain\Round;

use App\Domain\Contest\Contest;
use App\Domain\MusicGenre\MusicGenre;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Round
{
    private UuidInterface $id;

    private bool $finished;

    private int $number;

    private MusicGenre $musicGenre;

    private Contest $contest;

    private array $roundsContestant;

    public function __construct(int $number, MusicGenre $musicGenre)
    {
        $this->id         = Uuid::uuid4();
        $this->finished   = false;
        $this->number     = $number;
        $this->musicGenre = $musicGenre;
    }

    public function contest(): Contest
    {
        return $this->contest;
    }
}
