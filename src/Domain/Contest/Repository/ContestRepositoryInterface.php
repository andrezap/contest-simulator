<?php

declare(strict_types=1);

namespace App\Domain\Contest\Repository;

use App\Domain\Contest\ContestInterface;

interface ContestRepositoryInterface
{
    public function store(ContestInterface $contest): void;

    public function hasActive(): bool;
}
