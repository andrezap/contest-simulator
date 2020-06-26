<?php
declare(strict_types=1);

namespace App\Domain\Contestant\Repository;

use App\Domain\Contest\ContestInterface;

interface ContestantRepositoryInterface
{
    public function findWinner(ContestInterface $contest);
}