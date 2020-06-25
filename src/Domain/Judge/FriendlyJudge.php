<?php

declare(strict_types=1);

namespace App\Domain\Judge;

//This judge gives every contestant a score of 8 unless they have a calculated contestant score of less than or equal to 3.0,
// in which case the FriendlyJudge gives a 7. If the contestant is sick, the FriendlyJudge awards a bonus point, regardless of calculated contestant score.
class FriendlyJudge extends AbstractJudge
{
    private const NAME = 'Friendly Judge';

    public function score() : int
    {

    }

    public function name() : string
    {
        return self::NAME;
    }
}