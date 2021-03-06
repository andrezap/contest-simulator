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
    private ?Collection $rounds;

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

    public function setIdFromString(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function addContestant(ContestantInterface $contestant): void
    {
        $this->contestants->add($contestant);
        $contestant->setContest($this);
    }

    /**
     * {@inheritDoc}
     */
    public function addJudges(array $judges): void
    {
        $this->judges = $judges;
    }

    public function addRound(RoundInterface $round): void
    {
        $this->rounds->add($round);
    }

    /**
     * @return Collection|ContestantInterface[]
     */
    public function contestants(): Collection
    {
        return $this->contestants;
    }

    public function start(): void
    {
        $this->active = true;
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function isDone(): bool
    {
        return $this->active === false;
    }

    public function finish(): void
    {
        $this->active = false;
    }

    /**
     * {@inheritDoc}
     */
    public function judges(): array
    {
        return $this->judges;
    }

    public function rounds(): ?Collection
    {
        return $this->rounds;
    }
}
