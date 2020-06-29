<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge;

use App\Domain\Judge\RockJudge;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\Round\RoundInterface;
use App\Domain\RoundContestant\RoundContestantInterface;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class RockJudgeTest extends WebTestCase
{
    /**
     * @return mixed[]
     */
    public function dataProviderCalculateScore(): array
    {
        return [
            [49, 5],
            [50, 8],
            [74.9, 8],
            [75, 10],
        ];
    }

    /**
     * @dataProvider dataProviderCalculateScore
     */
    public function testCalculateScoreWhenTheMusicGenreIsRock(float $score, int $expected): void
    {
        $round = $this->createMock(RoundInterface::class);
        $round->expects(self::once())->method('musicGenre')->willReturn(MusicGenre::ROCK());

        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::once())->method('score')->willReturn($score);
        $roundContestant->expects(self::once())->method('round')->willReturn($round);

        $judge = new RockJudge();

        $finalScore = $judge->calculateScore($roundContestant);

        self::assertEquals($expected, $finalScore);
    }

    public function testCalculateScoreWhenTheMusicGenreIsNotRock(): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::never())->method('score');

        $judge = new RockJudge();

        $finalScore = $judge->calculateScore($roundContestant);

        self::assertLessThanOrEqual(10, $finalScore);
    }
}
