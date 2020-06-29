<?php

declare(strict_types=1);

namespace App\FixtureBuilder;

use App\Domain\Contest\Contest;
use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\ContestantInterface;
use App\FixtureBuilder\Loaders\RoundContestantBuilder;
use App\FixtureBuilder\Loaders\UuidLoader;

final class ContestBuilder
{
    private ContestInterface $contest;

    private function __construct()
    {
        $this->contest = new Contest();
    }

    public static function create() : self
    {
        return new self();
    }

    public static function buildForIdentifier(int $identifier) : ContestInterface
    {
        return self::forIdentifier($identifier)->build();
    }

    public function build() : ContestInterface
    {
        return $this->contest;
    }

    public static function forIdentifier(int $identifier) : self
    {
        $self = new self();
        $self->withId($identifier);

        return $self;
    }

    public function withId(int $identifier) : self
    {
        $this->contest->setIdFromString(UuidLoader::forIdentifier($identifier));

        return $this;
    }

    public function withCreatedAt(\DateTimeImmutable $createdAt) : self
    {
        $this->contest->setCreatedAt($createdAt);

        return $this;
    }

    public function withContestant(ContestantInterface $contestant) : self
    {
        $this->contest->addContestant($contestant);

        return $this;
    }

}