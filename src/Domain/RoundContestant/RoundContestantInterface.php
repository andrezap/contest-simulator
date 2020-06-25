<?php

declare(strict_types=1);

namespace App\Domain\RoundContestant;

interface RoundContestantInterface
{
    public function calculateScore(): void;
}
