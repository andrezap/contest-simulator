<?php

declare(strict_types=1);

namespace App\Domain\Contestant\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Contestant;
use Faker\Factory;
use Faker\Generator;

final class ContestantGenerator
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function generateForContest(ContestInterface $contest): void
    {
        for ($i = 0; $i < $contest::MAX_NUMBER_CONTESTANTS; $i++) {
            $genreStrength = MusicGenreGenerator::random();
            $contestant    = new Contestant($this->faker->name, $genreStrength);
            $contest->addContestant($contestant);
        }
    }
}
