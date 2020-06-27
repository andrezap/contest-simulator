<?php

declare(strict_types=1);

namespace App\Domain\Contest;

use App\Domain\Contestant\ContestantInterface;
use App\Domain\Judge\JudgeInterface;
use App\Domain\Round\RoundInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Contest implements ContestInterface
{
    private UuidInterface $id;

    /** @var Collection|RoundInterface[] */
    private Collection $rounds;

    /** @var Collection|ContestantInterface[] */
    private Collection $contestants;

    private bool $active;

    /** @var JudgeInterface[] */
    private array $judges;

    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->id          = Uuid::uuid4();
        $this->active      = false;
        $this->createdAt   = new \DateTimeImmutable();
        $this->rounds      = new ArrayCollection();
        $this->contestants = new ArrayCollection();
        $this->judges      = [];
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function addContestant(ContestantInterface $contestant): void
    {
        $this->contestants->add($contestant);
    }

    public function addJudges(array $judges): void
    {
        $this->judges = $judges;
    }

    public function addRound(RoundInterface $round): void
    {
        $this->rounds->add($round);
    }

    public function contestants(): Collection
    {
        return $this->contestants;
    }

    public function start(): void
    {
        $this->active = true;
    }

    public function isDone(): bool
    {
        return $this->active === false;
    }

    public function finish(): void
    {
        $this->active = false;
    }

    public function judges(): array
    {
        return $this->judges;
    }
}
