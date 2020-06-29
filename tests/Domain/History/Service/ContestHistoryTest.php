<?php

declare(strict_types=1);

namespace App\Tests\Domain\History\Service;

use App\Domain\Contestant\Repository\ContestantRepositoryInterface;
use App\Domain\History\History;
use App\Domain\History\Service\CreateHistory;
use App\FixtureBuilder\Loaders\UuidLoader;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class ContestHistoryTest extends WebTestCase
{
    public function testCreateHistory(): void
    {
        $repositoryMock = $this->createMock(ContestantRepositoryInterface::class);
        $winners        = [];

        for ($i = 0; $i < 5; $i++) {
            $winners[] = [
                'name' => 'Contestant ' . $i,
                'score' => $i * 2,
                'id' => UuidLoader::forIdentifier($i),
            ];
        }

        $repositoryMock->expects(self::once())->method('findLastFiveWinners')->willReturn($winners);
        $repositoryMock->expects(self::once())->method('findHighestScoreForAllContests')->willReturn($winners[4]);

        $createHistory = new CreateHistory($repositoryMock);
        $history       = $createHistory->execute();

        self::assertEquals('Contestant 4', $history[History::TOP_WINNER_KEY]['name']);
        self::assertEquals(UuidLoader::forIdentifier(4), $history[History::TOP_WINNER_KEY]['id']);

        self::assertCount(5, $history[History::WINNERS_KEY]);

        for ($i = 0; $i < 5; $i++) {
            self::assertEquals($winners[$i], $history[History::WINNERS_KEY][$i]);
        }
    }

    public function testCreateHistoryWhenNoContestWasCreated(): void
    {
        $repositoryMock = $this->createMock(ContestantRepositoryInterface::class);
        $winners        = [];

        $repositoryMock->expects(self::once())->method('findLastFiveWinners')->willReturn($winners);
        $repositoryMock->expects(self::once())->method('findHighestScoreForAllContests')->willreturn(null);

        $createHistory = new CreateHistory($repositoryMock);
        $history       = $createHistory->execute();

        self::assertNull($history[History::TOP_WINNER_KEY]);
        self::assertCount(0, $history[History::WINNERS_KEY]);
    }
}
