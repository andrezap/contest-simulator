<?php

declare(strict_types=1);

namespace App\FixtureBuilder;

use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\ContestantInterface;
use App\Domain\Contestant\Service\GenreStrengthGenerator;
use App\FixtureBuilder\Loaders\UuidLoader;

final class ContestantBuilder
{
    private const DEFAULT_NAME = 'Max Mustermann';

    private ContestantInterface $contestant;

    private function __construct()
    {
        $genreStrength    = GenreStrengthGenerator::execute();
        $this->contestant = new Contestant(self::DEFAULT_NAME, $genreStrength);
    }

    public static function buildForIdentifier(int $identifier) : ContestantInterface
    {
        return self::forIdentifier($identifier)->build();
    }

    public function build() : ContestantInterface
    {
        return $this->contestant;
    }

    public static function forIdentifier(int $identifier) : self
    {
        $self = new self();
        $self->withId($identifier);

        return $self;
    }

    public function withId(int $identifier) : self
    {
        $this->contestant->setIdFromString(UuidLoader::forIdentifier($identifier));

        return $this;
    }

    public static function create() : self
    {
        return new self();
    }

    public function asWinner() : self
    {
        $this->contestant->markAsWinner();

        return $this;
    }

    public function withName(string $name) : self
    {
        $this->contestant->setName($name);

        return $this;
    }
}