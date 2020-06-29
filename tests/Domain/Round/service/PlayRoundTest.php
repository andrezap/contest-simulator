<?php

declare(strict_types=1);

namespace App\Tests\Domain\Round\service;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contest\Exception\InvalidContestException;
use App\Domain\Contestant\Contestant;
use App\Domain\Contestant\Service\GenreStrengthGenerator;
use App\Domain\Judge\Service\JudgeContestantRound;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\Round\Repository\RoundRepositoryInterface;
use App\Domain\Round\RoundInterface;
use App\Domain\Round\Service\PlayRound;
use App\Domain\RoundContestant\RoundContestant;
use Doctrine\Common\Collections\ArrayCollection;
use Speicher210\FunctionalTestBundle\Test\WebTestCase;

final class PlayRoundTest extends WebTestCase
{
    public function testThrowExceptionIfContestHasNoRound(): void
    {
        $contestMock = $this->createMock(ContestInterface::class);
        $contestMock->expects(self::once())->method('isDone')->willReturn(false);

        $roundRepositoryMock = $this->createMock(RoundRepositoryInterface::class);
        $roundRepositoryMock->expects(self::once())->method('nextRoundForContest')->willReturn(null);

        $this->expectException(InvalidContestException::class);
        $this->expectExceptionMessage('Contest has an invalid state.');

        $playRound = new PlayRound($roundRepositoryMock, new JudgeContestantRound());
        $playRound->execute($contestMock);
    }

    public function testThrowExceptionIfContestIsDone(): void
    {
        $contestMock = $this->createMock(ContestInterface::class);
        $contestMock->expects(self::once())->method('isDone')->willReturn(true);

        $roundRepositoryMock = $this->createMock(RoundRepositoryInterface::class);

        $this->expectException(InvalidContestException::class);
        $this->expectExceptionMessage('Contest has an invalid state.');

        $playRound = new PlayRound($roundRepositoryMock, new JudgeContestantRound());
        $playRound->execute($contestMock);
    }

    public function testPlayRound(): void
    {
        $contestMock = $this->createMock(ContestInterface::class);
        $contestMock->expects(self::once())->method('isDone')->willReturn(false);

        $genreStrength = GenreStrengthGenerator::execute();
        $contestant    = new Contestant('John Doe', $genreStrength);

        $contestMock->expects(self::once())->method('contestants')->willReturn(new ArrayCollection([$contestant]));

        $roundMock = $this->createMock(RoundInterface::class);
        $roundMock->expects(self::once())->method('finish');
        $roundMock->expects(self::once())->method('musicGenre')->willReturn(MusicGenre::COUNTRY());
        $roundMock->expects(self::once())->method('addRoundContestant')->with(
            self::callback(
                static function (RoundContestant $roundContestant): bool {
                    self::assertLessThanOrEqual(100, $roundContestant->score());

                    return true;
                }
            )
        );

        $roundRepositoryMock = $this->createMock(RoundRepositoryInterface::class);
        $roundRepositoryMock->expects(self::once())->method('nextRoundForContest')->willReturn($roundMock);

        $playRound = new PlayRound($roundRepositoryMock, new JudgeContestantRound());
        $playRound->execute($contestMock);
    }
}
