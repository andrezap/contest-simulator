<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Domain\Contestant\Repository\Fixtures\Loaders;

use App\FixtureBuilder\ContestantBuilder;
use App\FixtureBuilder\ContestBuilder;
use App\FixtureBuilder\Loaders\RoundContestantBuilder;
use App\FixtureBuilder\RoundBuilder;
use Speicher210\FunctionalTestBundle\Test\Loader\AbstractLoader;

final class LoadContests extends AbstractLoader
{
    public function doLoad(): void
    {
        for ($i = 1; $i < 8; $i++) {
            $contestant_1 = ContestantBuilder::create()->build();
            $contestant_2 = ContestantBuilder::forIdentifier($i)->asWinner()->build();

            $createdAt = sprintf('+%d days', $i);

            $contest = ContestBuilder::forIdentifier($i)
                ->withCreatedAt(new \DateTimeImmutable($createdAt))
                ->withContestant($contestant_1)
                ->withContestant($contestant_2)
                ->build();

            $round = RoundBuilder::createForContest($contest)->build();

            $roundContestant_1 = RoundContestantBuilder::create($round, $contestant_1)->withFinalScore(1)->build();
            $roundContestant_2 = RoundContestantBuilder::create($round, $contestant_2)->withFinalScore(2 * $i)->build();

            $this->persist($round);
            $this->persist($roundContestant_1);
            $this->persist($roundContestant_2);
            $this->persist($contest);
        }
    }
}
