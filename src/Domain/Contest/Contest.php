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

    /** @var Collection|JudgeInterface */
    private Collection $judges;

    public function __construct()
    {
        $this->id          = Uuid::uuid4();
        $this->active      = false;
        $this->rounds      = new ArrayCollection();
        $this->contestants = new ArrayCollection();
    }

    public function id() : UuidInterface
    {
        return $this->id;
    }

    public function addContestant(ContestantInterface $contestant) : void
    {
        $this->contestants->add($contestant);
    }

    public function addJudge(JudgeInterface $judge) : void
    {
        $this->judges->add($judge);
    }

    public function addRound(RoundInterface $round) : void
    {
        $this->rounds->add($round);
    }

    public function getContestants() : Collection
    {
        return $this->contestants;
    }

    public function start() : void
    {
        $this->active = true;
    }

    public function isDone() : bool
    {
        return $this->active === false;
    }

    public function finish() : void
    {
        $this->active = false;
    }
}
