<?php

declare(strict_types=1);

namespace App\Tests\Domain\Contestant\Service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\Service\ContestantGenerator;
use App\Domain\MusicGenre\MusicGenre;
use App\FixtureBuilder\ContestBuilder;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class ContestantGeneratorTest extends WebTestCase
{
    public function testContestantGenerator(): void
    {
        $contest   = ContestBuilder::create()->build();
        $generator = new ContestantGenerator();
        $generator->generateForContest($contest);

        self::assertCount(ContestInterface::MAX_NUMBER_CONTESTANTS, $contest->contestants());

        $contestants = $contest->contestants();

        foreach ($contestants as $contestant) {
            $genreStrengths = $contestant->allGenreStrengths();
            $expected       = count(MusicGenre::getOrdinals());
            self::assertCount($expected, $genreStrengths);
        }
    }
}
