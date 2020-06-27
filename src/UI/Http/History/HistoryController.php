<?php

declare(strict_types=1);

namespace App\UI\Http\History;

use App\Domain\Contest\Service\ContestHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HistoryController extends AbstractController
{
    private ContestHistory $contestHistory;

    public function __construct(ContestHistory $contestHistory)
    {
        $this->contestHistory = $contestHistory;
    }

    public function show(): Response
    {
        $history = $this->contestHistory->execute();

        return $this->render('history.html.twig', ['history' => $history]);
    }
}
