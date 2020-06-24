<?php

declare(strict_types=1);

namespace App\Domain\Contest;

use App\Domain\Contestant\Contestant;
use App\Domain\MusicGenre\MusicGenre;
use App\Domain\Round\Round;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Contest implements ContestInterface
{
    private UuidInterface $id;

    /** @var Collection|Round[] */
    private Collection $rounds;

    /** @var Collection|Contestant[] */
    private Collection $contestants;

    public function __construct()
    {
        $this->id          = Uuid::uuid4();
        $this->rounds      = new ArrayCollection();
        $this->contestants = new ArrayCollection();
        $this->generateContestants();
        $this->generateRounds();
    }

    public function generateRounds(): void
    {
        $genders = MusicGenre::getEnumerators();
        \shuffle($genders);
        for ($i = 0; $i < self::MAX_NUMBER_ROUNDS; $i++) {
            $this->rounds->add(new Round($i, $genders[$i]));
        }
    }

    public function generateContestants(): void
    {
        for ($i = 0; $i < self::MAX_NUMBER_CONTESTANTS; $i++) {
            $this->contestants->add(new Contestant($this));
        }
    }
}
