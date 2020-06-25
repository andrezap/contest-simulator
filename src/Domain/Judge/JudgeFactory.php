<?php

declare(strict_types=1);

namespace App\Domain\Judge;

use App\Domain\Judge\Exception\JudgeNotFound;

class JudgeFactory
{
    public static function build(JudgeType $type)
    {
        $className = ucfirst($type) . 'Judge';

        if (class_exists($className)) {
            return new $className();
        }

        throw new JudgeNotFound();
    }
}