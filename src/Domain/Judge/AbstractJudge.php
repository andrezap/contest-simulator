<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractJudge implements JudgeInterface
{
    private UuidInterface $id;

    private string $name;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }
}