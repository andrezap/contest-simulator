<?php

declare(strict_types=1);

namespace App\Domain\Contest;

use App\Domain\Contestant\ContestantInterface;
use App\Domain\Round\RoundInterface;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface ContestInterface
{
    public const MAX_NUMBER_ROUNDS      = 6;
    public const MAX_NUMBER_CONTESTANTS = 10;
    public const MAX_NUMBER_JUDGES      = 3;

    public function id() : UuidInterface;

    public function addContestant(ContestantInterface $contestant) : void;

    public function addJudges(array $judges) : void;

    public function addRound(RoundInterface $round) : void;

    /**
     * @return ContestantInterface[]|Collection
     */
    public function getContestants() : Collection;

    public function start() : void;

    public function isDone() : bool;

    public function finish() : void;

    public function getJudges() : array;
}
