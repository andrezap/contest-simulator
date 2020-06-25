<?php

declare(strict_types=1);

namespace App\Domain\Judge;

interface JudgeInterface
{
    public function score() : int;

    public function name() : string;
}