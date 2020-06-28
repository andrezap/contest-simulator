<?php

declare(strict_types=1);

namespace App\Domain\Contest;

use App\Domain\Contestant\ContestantInterface;
use App\Domain\Judge\JudgeInterface;
use App\Domain\Round\RoundInterface;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface ContestInterface
{
    public const MAX_NUMBER_ROUNDS      = 6;
    public const MAX_NUMBER_CONTESTANTS = 10;
    public const MAX_NUMBER_JUDGES      = 3;

    public function id(): UuidInterface;

    /**
     * @internal Used only for test purpose
     */
    public function setIdFromString(string $id): void;

    public function createdAt(): \DateTimeImmutable;

    public function setCreatedAt(\DateTimeImmutable $createdAt): void;

    public function addContestant(ContestantInterface $contestant): void;

    /**
     * @param JudgeInterface[] $judges
     */
    public function addJudges(array $judges): void;

    public function addRound(RoundInterface $round): void;

    /**
     * @return Collection|ContestantInterface[]
     */
    public function contestants(): Collection;

    public function start(): void;

    public function isDone(): bool;

    public function finish(): void;

    /**
     * @return JudgeInterface[]
     */
    public function judges(): array;
}
