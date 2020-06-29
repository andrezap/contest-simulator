<?php

declare(strict_types=1);

namespace App\Tests\Domain\Judge;

use App\Domain\Judge\HonestJudge;
use App\Domain\RoundContestant\RoundContestantInterface;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class HonestJudgeTest extends WebTestCase
{
    /**
     * @return mixed[]
     */
    public function dataProviderCalculateScore(): array
    {
        return [
            [5, 1],
            [10, 1],
            [10.1, 2],
            [19, 2],
            [20.1, 3],
            [29, 3],
            [30.1, 4],
            [39, 4],
            [40.1, 5],
            [49, 5],
            [50.1, 6],
            [59, 6],
            [60.1, 7],
            [69, 7],
            [70.1, 8],
            [79, 8],
            [80.1, 9],
            [89, 9],
            [90, 10],
        ];
    }

    /**
     * @dataProvider dataProviderCalculateScore
     */
    public function testCalculateScore(float $score, int $expected): void
    {
        $roundContestant = $this->createMock(RoundContestantInterface::class);
        $roundContestant->expects(self::once())->method('score')->willReturn($score);

        $judge = new HonestJudge();

        $finalScore = $judge->calculateScore($roundContestant);

        self::assertEquals($expected, $finalScore);
    }
}
