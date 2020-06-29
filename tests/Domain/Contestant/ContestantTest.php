<?php

declare(strict_types=1);

namespace App\Tests\Domain\Contestant;

use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\Service\GenreStrengthGenerator;
use App\Domain\MusicGenre\MusicGenre;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class ContestantTest extends WebTestCase
{
    public function testReturnStrengthForAMusicGenre(): void
    {
        $genreStrength = GenreStrengthGenerator::execute();
        $contestant    = new Contestant('John Doe', $genreStrength);
        $genreStrength = $contestant->genreStrength(MusicGenre::COUNTRY());

        self::assertLessThanOrEqual(10, $genreStrength);
    }
}
