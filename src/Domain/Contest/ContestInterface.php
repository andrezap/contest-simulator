<?php

declare(strict_types=1);

namespace App\Domain\Contest;

interface ContestInterface
{
    public const MAX_NUMBER_ROUNDS      = 6;
    public const MAX_NUMBER_CONTESTANTS = 10;

    public function generateRounds(): void;

    public function generateContestants(): void;
}
