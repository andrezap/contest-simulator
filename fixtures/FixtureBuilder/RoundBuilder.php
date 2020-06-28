<?php

declare(strict_types=1);

namespace App\FixtureBuilder;

use App\Domain\Contest\ContestInterface;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\Round\Round;
use App\Domain\Round\RoundInterface;

final class RoundBuilder
{
    private const DEFAULT_NUMBER = 1;

    private RoundInterface $round;

    private function __construct(ContestInterface $contest)
    {
        $gender      = MusicGenre::byOrdinal(1);
        $this->round = new Round($contest, $gender, self::DEFAULT_NUMBER);
    }

    public static function createForContest(ContestInterface $contest) : self
    {
        return new self($contest);
    }

    public function withId(string $id) : self
    {
        $this->round->setIdFromString($id);

        return $this;
    }

    public function withNumber(int $number) : self
    {
        $this->round->setNumber($number);

        return $this;
    }

    public function build() : RoundInterface
    {
        return $this->round;
    }
}