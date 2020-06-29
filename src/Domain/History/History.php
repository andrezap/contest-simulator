<?php

declare(strict_types=1);

namespace App\Domain\History;

use App\Domain\Contestant\ContestantInterface;

final class History
{
    public const WINNERS_KEY    = 'winners';
    public const TOP_WINNER_KEY = 'topWinner';

    /** @var ContestantInterface[]|array */
    private array $winners;

    /** @var mixed[]|null */
    private ?array $topWinner;

    /**
     * @param ContestantInterface[] $winners
     * @param mixed[]               $topWinner
     */
    public function __construct(array $winners, ?array $topWinner)
    {
        $this->winners   = $winners;
        $this->topWinner = $topWinner;
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            self::WINNERS_KEY => $this->winners,
            self::TOP_WINNER_KEY => $this->topWinner,
        ];
    }
}
