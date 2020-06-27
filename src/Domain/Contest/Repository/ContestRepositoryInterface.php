<?php

declare(strict_types=1);

namespace App\Domain\Contest\Repository;

use App\Domain\Contest\ContestInterface;
use App\Domain\Contestant\ContestantInterface;

interface ContestRepositoryInterface
{
    public function store(ContestInterface $contest): void;

    public function hasActive(): bool;

    public function findWinner(ContestInterface $contest): ContestantInterface;
}
